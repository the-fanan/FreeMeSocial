<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Media;
use App\User;
use Illuminate\Support\Facades\Validator;
use JD\Cloudder\Facades\Cloudder;

class MediaController extends Controller
{
    private $currentUser;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->currentUser = Auth::user();
            return $next($request);
        });
    }

    /**
     * Functions related to routes
     */
    public function upload(Request $request) {
        if (empty($this->currentUser->ownGroups()->first())) {
           //user has no group yet so create family and friends group
           $this->currentUser->createAndAssociateGroups();
        } 

        $validator = Validator::make($request->all(), [
            "description" => "required|max:255|string",
            "media" => "required|mimetypes:video/3gpp,video/mp4,video/mpeg,video/ogg,video/webm,image/bmp,image/gif,image/jpeg,image/png,image/tiff",
            "restriction" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Post no uploaded! Ensure all fields are filled and image or video is being uploaded.', 'alertClass' => 'list-group-item-danger']);
        }

        $is_publlic = 0;
        if ($request->restriction == "public") {
            $is_public = 1;
        }
        //upload file
        $mediaMimeType = $request->media->getMimeType();
        $mimeParts = explode("/", $mediaMimeType);
        $url = $this->uploadFile($request->media, $mimeParts[0]);
        //create post
        $post = $this->currentUser->ownPosts()->create([
            'description' => $request->description,
            'type' => $mimeParts[0],
            'url' => $url['secure_url'],
            'is_public' => $is_public
        ]);
        //attach to groups based on permission
        /**
         * public is still placed here to ensure thay=t family and freinds are included in a public post
         */
        $userFriends = $this->currentUser->ownFriends();
        $userFamily = $this->currentUser->ownFamily();
        //return response()->json(['message' => json_encode($userFamily), 'alertClass' => 'list-group-item-success']);
        switch ($request->restriction) {
            case "public":
                $userFriends->posts()->attach($post);
                $userFamily->posts()->attach($post);
                break;
            case "friends":
                $userFriends->posts()->attach($post);
                break;
            case "family":
                $userFamily->posts()->attach($post);
                break;
            case "freinds-family":
                $userFriends->posts()->attach($post);
                $userFamily->posts()->attach($post);
                break;
        }
        
        return response()->json(['message' => 'Post succesfuly added.', 'alertClass' => 'list-group-item-success']);
    }

    public function archive(Request $request) {
        $post = Media::find($request->postId);
        if (is_null($post)) {
            return response()->json(["error" => "No post found"]);
        }
        $post->is_archived = 1;
        $post->save();
        return response()->json(["success" => "success"]);
    }

    public function unarchive(Request $request) {
        $post = Media::find($request->postId);
        if (is_null($post)) {
            return response()->json(["error" => "No post found"]);
        }
        $post->is_archived = 0;
        $post->save();
        return response()->json(["success" => "success"]);
    }

    public function trash(Request $request) {
        $post = Media::find($request->postId);
        if (is_null($post)) {
            return response()->json(["error" => "No post found"]);
        }
        $post->is_trashed = 1;
        $post->save();
        return response()->json(["success" => "success"]);
    }

    public function untrash(Request $request) {
        $post = Media::find($request->postId);
        if (is_null($post)) {
            return response()->json(["error" => "No post found"]);
        }
        $post->is_trashed = 0;
        $post->save();
        return response()->json(["success" => "success"]);
    }

    public function restrict(Request $request) {
        $post = Media::find($request->postId);
        if (is_null($post)) {
            return response()->json(["error" => "No post found"]);
        }

        $userFriends = $this->currentUser->ownFriends();
        $userFamily = $this->currentUser->ownFamily();

        switch ($request->restriction) {
            case "public":
                $post->is_public = 1;
                $post->save();
                $userFriends->posts()->detach($post);
                $userFamily->posts()->detach($post);
                $userFriends->posts()->attach($post);
                $userFamily->posts()->attach($post);
                break;
            case "friends":
                $post->is_public = 0;
                $post->save();
                $userFriends->posts()->detach($post);
                $userFamily->posts()->detach($post);

                $userFriends->posts()->attach($post);
                
                break;
            case "family":
                $post->is_public = 0;
                $post->save();
                $userFriends->posts()->detach($post);
                $userFamily->posts()->detach($post);
                $userFamily->posts()->attach($post);
                break;
            case "freinds-family":
                $post->is_public = 0;
                $post->save();
                $userFriends->posts()->detach($post);
                $userFamily->posts()->detach($post);
                $userFriends->posts()->attach($post);
                $userFamily->posts()->attach($post);
                break;
        }
    }

    /**
     * Posts to return when owner of profile page is viewing profile
     */
    public function returnUserPosts(Request $request) {
        $currentUser = User::find($request->currentUser);
        $pageOwner = User::find($request->pageOwner);
        $returnData = [];
        if ($currentUser->id == $pageOwner->id) {
            $returnData = $pageOwner->getAllUserPosts();
        } elseif(!empty($this->currentUser->groups()->where('owner_id', $pageOwner->id)->first()))  {
            $returnData = $this->currentUser->getPageOwnerRelationPosts($pageOwner);
        } else {
            $returnData = $pageOwner->getUserPublicPosts();
        }
        switch ($request->type) {
            case "posts":
                //chill...
                return $returnData;
                break;
            case "archive":
                return $this->currentUser->getUserArchives();
                break;
            case "trash":
                return $this->currentUser->getUserTrashed();
                break;
        }
    }

    /**
     * Functions not related to routes
     */
    public function uploadFile($resource, $type) {
        $fileName = time() . str_random(4) . "." .  $resource->extension();
        if ($type == "image") {
            Cloudder::upload($resource->getRealPath(), $fileName, ["unique_filename" => false]);
        }elseif($type == "video") {
            Cloudder::uploadVideo($resource->getRealPath(), $fileName, ["unique_filename" => false]);
        }
        //$savePath = "uploads/" . $fileName;
        //$resource->storeAs("uploads/", $fileName);
        return Cloudder::getResult();
    }

}

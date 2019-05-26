<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

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

        $mediaMimeType = $request->media->getMimeType();
        $mimeParts = explode("/", $mediaMimeType);
        $url = $this->uploadFile($request->media);
        return response()->json(['message' => 'Post succesfuly added. ' . $request->media->extension(), 'alertClass' => 'list-group-item-success']);
    }

    /**
     * Functions not related to routes
     */
    public function uploadFile($resource) {
        $fileName = time() . str_random(4) . "." .  $resource->extension();
        $savePath = "uploads/" . $fileName;
        $resource->storeAs("uploads/", $fileName);
        return $savePath;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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


    public function upload(Request $request) {
        if (empty($this->currentUser->ownGroups()->first())) {
           //user has no group yet so create family and friends group
           $this->currentUser->createAndAssociateGroups();
        } 

        $mediaMimeType = $request->media->getMimeType();
        $mimeParts = explode("/", $mediaMimeType);
        return "Post succesfuly added! " . $mimeParts[0] ;
    }
}

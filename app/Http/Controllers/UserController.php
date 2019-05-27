<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
class UserController extends Controller
{
    private $currentUser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->currentUser = Auth::user();
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pageOwner = User::where('username', $request->user)->first();
        if (is_null($pageOwner)) {
            return view('errors.404');
        }
        $props = ['pageOwner' => $pageOwner, 'currentUser' => $this->currentUser];
        return view('user.profile', compact('props'));
    }

    public function addFriend(Request $request) {
        $this->currentUser->ownFriends()->members()->attach($request->pageOwner);
    }

    public function addFamily(Request $request) {
        $this->currentUser->ownFamily()->members()->attach($request->pageOwner);
    }
}

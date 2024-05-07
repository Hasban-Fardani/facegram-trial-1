<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return response()->json([
            'users' => $users
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->loadCount(['followers', 'following']);
        $is_your_account = auth()->user()->id == $user->id;
        
        $follow = Follow::where('following_id', $user->id)
            ->where('follower_id', auth()->user()->id)
            ->first();
        
        $followStatus = 'not-following';
        if ($follow) {
            $followStatus = $follow->is_accepted ? 'following' : 'requested';
        }

        if (!$user->is_private || ($user->is_private && $followStatus == 'following'))
        {
            $user = $user->load(['posts', 'posts.attachments']);
        }

        $user->following_status = $followStatus;
        $user->is_your_account = $is_your_account;
        
        return response()->json([
            'user' => $user
        ], 200);
    }
}

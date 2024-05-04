<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $status = 'following';

        // check user if same 
        $authUser = auth()->user();
        if ($authUser->id == $user->id)
        {
            return response()->json([
                'message' => 'You are not allowed to follow yourself'
            ], 422);
        }

        // check already following
        $follow = Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->first();
        if ($follow)
        {
            $status = $follow->is_accepted ? 'following' : 'requested';
            return response()->json([
                'message' => 'You are already followed',
                'status' => $status
            ], 422);
        }

        // check if followig user is private
        $is_accepted = true;
        if ($user->is_private) 
        {
            $is_accepted = false;
            $status = 'requested';
        }

        // success followed
        Follow::create([
            'follower_id' => $authUser->id,
            'following_id' => $user->id,
            'is_accepted' => $is_accepted
        ]);

        return response()->json([
            'message' => 'Follow success',
            'status' => $status
        ], 200);
    }

    public function unfollow(User $user)
    {
        $authUser = auth()->user();

        // check already following
        $follow = Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->first();
        if (!$follow)
        {
            return response()->json([
                'message' => 'You are not following the user',
            ], 422);
        }

        $follow->delete();

        return response()->json(null, 204);
    }

    public function followers()
    {
        $followers_id = Follow::where('following_id', auth()->user()->id)
            ->get()
            ->pluck('follower_id');
        
        $users = User::whereIn('id', $followers_id)->get();

        return response()->json([
            'followers' => $users
        ], 200);
    }

    public function following()
    {
        $followings_id = Follow::where('follower_id', auth()->user()->id)
            ->get()
            ->pluck('following_id');
        
        $users = User::whereIn('id', $followings_id)->get();
        
        return response()->json([
            'followers' => $users
        ], 200);
    }

    public function accept(User $user)
    {
        $authId = auth()->user()->id;
        $follow = Follow::where('follower_id', $authId)
            ->where('following_id', $user->id)
            ->first();

        if (!$follow) 
        {
            return response()->json([
                'message' => 'The user is not following you'
            ], 422);
        }

        if ($follow->is_accepted)
        {
            return response()->json([
                'message' => 'Follow request is already accepted'
            ], 422);
        }

        $follow->update([
            'is_accepted' => true,
        ]);

        return response()->json([
            'message' => "Follow request is accepted"
        ], 200);
    }
}

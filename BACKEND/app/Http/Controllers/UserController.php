<?php

namespace App\Http\Controllers;

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
        
        if (!$user->is_private)
        {
            $user = $user->load(['posts', 'posts.attachments']);
        }

        return response()->json([
            'user' => $user
        ], 200);
    }
}

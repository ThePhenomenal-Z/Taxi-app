<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\updateUserRequest;

class UserController extends Controller
{
        // constructing policy
        public function __construct()
        {
            $this->authorizeResource(User::class, 'user');
        }
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $userId = auth()->id();
            $user = User::findOrFail($userId);
            return new UserResource($user);
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function updateUser(updateUserRequest $request)
        {
            $this->authorize('updateUser', User::class);
            $validated = $request->validated();
            $userId = auth()->id();
            $user = User::find($userId);
            $user->update($validated);
            return new UserResource($user);
        }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\CreatedUserResource;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only(['email', 'password']) + ['name' => $request->input('child.name')]);
        /* @var \App\Models\Child $child */
        $child = $user->children()->create($request->get('child'));
        if ($request->file('child.image'))
            $child->addMediaFromRequest('child.image')->toMediaCollection('profile');

        return new CreatedUserResource($user);
    }
}

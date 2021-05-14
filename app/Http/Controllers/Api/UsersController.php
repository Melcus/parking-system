<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::all();
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if (env('APP_ALLOW_NO_MARANATHA_ACCOUNTS') === 'false'){
            if (!str_contains($data['email'], '@maranatha')){
                return response()->json(['message' => 'Your account registration is being analized'], 403);
            }
        }

        $data['username'] = strtolower($data['username']);

        $user = User::create($data);
        return response()->json(['message' => 'User created', 'user' => $user->toArray()]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(['message' => 'User updated', 'user' => $user->toArray()]);
    }

    public function destroy(User $user)
    {
        if ($user->username === 'admin'){
            return response()->json(['message' => 'You can not delete the admin'], 403);
        }

        if (!auth()->user()->isAdmin()){
            return response()->json(['message' => 'You do not have permission to delete users'], 403);
        }

        $user->reports()->delete();
        $user->tokens()->delete();
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function deleteMyAccount()
    {
        if ($user->username !== 'admin'){
            return response()->json(['message' => 'You can not delete the admin'], 403);
        }

        $user = auth()->user();
        $user->reports()->delete();
        $user->tokens()->delete();
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function addRole(Request $request, User $user)
    {
        return response()->json(['message' => 'Role added']);
    }

    public function removeRole(Request $request, User $user)
    {
        $user->removeRole($request->role_id);
        return response()->json(['message' => 'Role removed']);
    }

    public function hasRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role_id)){
            return response()->json(true, 200);
        }else{
            return response()->json(false, 404);
        }
    }

    public function roles(User $user)
    {
        return response()->json($user->roles());
    }
}

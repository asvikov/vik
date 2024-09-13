<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use function Symfony\Component\Clock\get;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);
        $users = User::all();
        return view('users/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        Gate::authorize('create', User::class);
        $roles = Role::all();

        $roles->map(function ($role) {
            if($role->name == 'guest') {
                $role->selected = true;
            }
        });
        return view('users/create', compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Gate::authorize('create', User::class);
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles'));
        return redirect('/users');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        $roles = Role::all();
        $ac_roles = $user->roles()->get(['roles.id']);
        $ac_roles = $ac_roles->toArray();
        $ac_roles = array_column($ac_roles, 'id');

        $roles->map(function ($role) use ($ac_roles) {
            if(in_array($role->id, $ac_roles)) {
                $role->selected = true;
            }
        });

        return view('users/edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        Gate::authorize('update', $user);
        $input = $request->all();

        if(!$input['password']) {
            unset($input['password']);
        }

        if($user) {
            $user->update($input);
            $user->roles()->sync($request->input('roles'));
        }
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        if($user) {
            $user->delete();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class UserController extends Controller
{
    public function list()
    {
        $users = User::select('id', 'name', 'email');

        return datatables($users)
            ->addColumn('action', function ($user) {
                // dd($user->roles);
                // dd($user->roles->where('name', 'super-admin')->count());

                $authUser = auth()->user();

                $action = '<form class="delete-form" action="' . route('admin.user.destroy', $user->id) . '" method="POST"><input type="hidden" name="_token" value="' . csrf_token() . '"><input type="hidden" name="_method" value="DELETE">';

                if ($authUser->can('admin.user.edit')) {
                    $action .= '<a href="' . route('admin.user.edit', $user->id) . '" class="btn btn-sm btn-warning">Sửa</a> ';
                }
                if (
                    $authUser->name != $user->name &&
                    $authUser->can('admin.user.destroy') &&
                    $user->roles->where('name', 'super-admin')->count() <= 0
                ) {
                    $action .= '<button type="submit" class="btn btn-sm btn-danger">Xoá</button>';
                }

                if (($authUser->cannot(['admin.user.edit', 'admin.user.destroy']))) {
                    $action .= "<span>Không có hành động nào</span>";
                }
                $action .= '</=form>';

                return $action;
            })
            ->rawColumns(['image', 'status', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $permissions = Permission::all();
        $roles = Role::all();
        $permissionsAssigned = $user->getPermissionNames();
        $rolesAssigned = $user->getRoleNames();

        return view('backend.user.edit', compact('permissions', 'roles', 'user', 'permissionsAssigned', 'rolesAssigned'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $roles = $request->roles;
        $user->syncRoles($roles);

        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user.index')->withSuccess('Xoá danh mục thành công');
    }
}

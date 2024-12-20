<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminUserRequest;
use App\Http\Controllers\BackendController;

class AdminUserController extends BackendController
{
    public function __construct()
    {
        $this->data['sitetitle'] = 'Administrator';

        $this->middleware(['permission:adminusers'])->only('index');
        $this->middleware(['permission:adminusers_create'])->only('create', 'store');
        $this->middleware(['permission:adminusers_edit'])->only('edit', 'update');
        $this->middleware(['permission:adminusers_delete'])->only('destroy');
        $this->middleware(['permission:adminusers_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.adminuser.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['roles'] = Role::whereNotIn('id',[2])->get();
        return view('admin.adminuser.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request)
    {
        $user                    = new User;
        $user->first_name        = $request->first_name;
        $user->last_name         = $request->last_name;
        $user->email             = $request->email;
        $user->country_code      = $request->country_code;
        $user->country_code_name = $request->country_code_name;
        $user->username          = $request->username ?? $this->username($request->email);
        $user->password          = Hash::make(request('password'));
        $user->phone             = $request->phone;
        $user->address           = $request->address;
        $user->status            = $request->status;
        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find($request->role_id);
        $user->assignRole($role->name);

        return redirect(route('admin.adminusers.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = User::findOrFail($id);

        return view('admin.adminuser.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->data['roles'] = Role::whereNotIn('id',[2])->get();
        $this->data['user'] = $user;
        return view('admin.adminuser.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->username   = $request->username ?? $this->username($request->email);

            if ($request->password) {
                $user->password = Hash::make(request('password'));
            }

            $user->phone             = $request->phone;
            $user->country_code      = $request->country_code;
            $user->country_code_name = $request->country_code_name;
            $user->address           = $request->address;

            if ($user->id == 1) {
                $user->status = $request->status;
                $role = Role::find(1);
                $user->assignRole($role->name);
            } else {
                $user->status = $request->status;
                $role = Role::find($request->role_id);
                $user->syncRoles([$role->name]);
            }
            $user->save();

            if (request()->file('image')) {
                $user->media()->delete();
                $user->addMedia(request()->file('image'))->toMediaCollection('user');
            }


            return redirect(route('admin.adminusers.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (($user->id != 1) && (auth()->id() == 1)) {
            $user->delete();
            return redirect(route('admin.adminusers.index'))->withSuccess('The Data Deleted Successfully');
        }
    }

    public function getAdminUsers()
    {
        

        $role = Role::find(UserRole::EMPLOYEE);

        $users = User::whereDoesntHave('roles', function ($query) use ($role) {
            $query->where('name', $role->name);
        })->get();
        
        $userArray = [];

        $i = 1;
        if (!blank($users)) {
            foreach ($users as $user) {
                $userArray[$i]          = $user;
                $userArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($userArray)
            ->addColumn('action', function ($user) {
                $retAction = '';
                if (($user->id == auth()->id()) && (auth()->id() == 1)) {
                    if (auth()->user()->can('adminusers_show')) {
                        $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('adminusers_edit')) {
                        $retAction .= '<a href="' . route('admin.adminusers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }
                } else if (auth()->id() == 1) {
                    if (auth()->user()->can('adminusers_show')) {
                        $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('adminusers_edit')) {
                        $retAction .= '<a href="' . route('admin.adminusers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('adminusers_delete')) {
                        $retAction .= "<form class='float-left pl-2' action='" . route('admin.adminusers.destroy', $user) . "' method='POST'>" . method_field('DELETE') . csrf_field() . "<button class='btn btn-sm btn-icon btn-danger' onclick='return confirmDelete()' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash'></i></button></form>";
                    }
                } else {
                    if ($user->id == 1) {
                        if (auth()->user()->can('adminusers_show')) {
                            $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                        }
                    } else {
                        if (auth()->user()->can('adminusers_show')) {
                            $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                        }

                        if (auth()->user()->can('adminusers_edit')) {
                            $retAction .= '<a href="' . route('admin.adminusers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2"><i class="far fa-edit"></i></a>';
                        }
                    }
                }

                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->images . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('id', function ($user) {
                return $user->setID;
            })
            ->escapeColumns([])
            ->make(true);
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }
}

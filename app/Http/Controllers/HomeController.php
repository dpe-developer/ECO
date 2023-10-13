<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use App\Models\User;
use App\Models\RolePermission\Role;
use App\Models\RolePermission\Permission;
use App\Models\LoginInfo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $data = [
            'users' => User::where('id', '!=', 1)->get(),
            'loginInfos' => LoginInfo::get(),
            'permissions' => Permission::get(),
            'roles' => Role::get(),
        ];
        return view('dashboard', $data);
    }
}

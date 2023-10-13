<?php

namespace App\Http\Controllers;

use App\Models\LoginInfo;
use Illuminate\Http\Request;
use Auth;

class LoginInfoController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('role:System Administrator');
		$this->middleware('permission:login_infos.index', ['only' => ['index']]);
		$this->middleware('permission:login_infos.create', ['only' => ['create','store']]);
		$this->middleware('permission:login_infos.show', ['only' => ['show']]);
		$this->middleware('permission:login_infos.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:login_infos.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:login_infos.restore', ['only' => ['restore']]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasrole('System Administrator') == 1){
			if($q = $request->get('q')){
				$loginInfos = LoginInfo::orderBy('id', 'desc')->where('username', 'LIKE', '%'.$q.'%')
							->orwhere('status', 'LIKE', '%'.$q.'%')
							->get();
			}else{
				$loginInfos = LoginInfo::orderBy('id', 'desc')->get();
			}
		}else{
				$loginInfos = LoginInfo::where('id', 0)->get();
		}
		return view('users.login_info.index', compact('loginInfos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoginInfo  $loginInfo
     * @return \Illuminate\Http\Response
     */
    public function show(LoginInfo $loginInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoginInfo  $loginInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(LoginInfo $loginInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoginInfo  $loginInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoginInfo $loginInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoginInfo  $loginInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoginInfo $loginInfo)
    {
        //
    }
}

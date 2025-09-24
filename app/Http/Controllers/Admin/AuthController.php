<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin\Admin;
use App\Models\Admin\AdminAuth;

use App\Libraries\General;

class AuthController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            if($request->has(['email', 'password']))
            {
                $validator = Validator::make(
                    $request->toArray(),
                    [
                        'email' => 'required|email',
                        'password' => 'required'
                    ]
                );

                if(!$validator->fails())
                {
                    $user = AdminAuth::attemptLogin($request);

                    if($user) 
                    {
                        
                        $user = AdminAuth::makeLoginSession($request, $user);
                        if($user)
                        {
                            return redirect()->route('admin.dashboard');
                        }
                        else
                        {
                            $request->session()->flash('error', 'Session could not be establised. Please try again.');
                            return redirect()->back()->withInput();     
                        }
                        
                    }
                    else
                    {
                        $request->session()->flash('error', 'The credentials that you\'ve entered doesn\'t match any account');
                        return redirect()->back()->withInput();
                    }
                }
                else
                {
                    $request->session()->flash('error', 'Please provide valid inputs.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
            else
            {
                $request->session()->flash('error', 'Invalid request.');
                return redirect()->back()->withInput();
            }
        }

    	return view("admin/auth/login");
    }

    function logout(Request $request)
    {
        AdminAuth::logout();
        return redirect()->route('admin.login');    
    }
}
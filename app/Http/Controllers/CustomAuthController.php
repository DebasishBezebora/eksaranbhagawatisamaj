<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamUsers;
use Hash;
use Session;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function registerUser(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:exam_users',
                'phone' => 'required|numeric',
                'password' => 'required|confirmed|min:8|max:12',
                'password_confirmation' => 'required',
                'status' => 'required',
                'agreeTerms' => 'required'
            ]
        );

        $ExamUsers = new ExamUsers();

        $ExamUsers->Name = $request->name;
        $ExamUsers->Email = $request->email;
        $ExamUsers->Mobile_Number = $request->phone;
        $ExamUsers->Password = Hash::make($request->password);
        $ExamUsers->Status = $request->status;

        $res = $ExamUsers->save();
        if ($res) :
            return back()->with('Success', 'You have been registered successfully.');
        else :
            return back()->with('Fail', 'Oops! Something is not right.');
        endif;
    }

    public function loginUser(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        $ExamUsers = ExamUsers::where('Email', '=', $request->email)->first();
        if ($ExamUsers) :
            if (Hash::check($request->password, $ExamUsers->Password)) :
                $request->session()->put('loginID', $ExamUsers->ID);
                return redirect('dashboard');
            else :
                return back()->with('Fail', 'Password doesn\'t match.');
            endif;
        else :
            return back()->with('Fail', 'Email doesn\'t exist.');
        endif;
    }

    public function dashboard()
    {
        $data = array();
        if (session()->has('loginID')) :
            $data = ExamUsers::where('ID', '=', Session::get('loginID'))->first();
        endif;
        return view('home', compact('data'));
    }

    public function logout()
    {
        if (session()->has('loginID')) :
            session()->pull('loginID');
            return redirect('login')->with('Success', 'Logout successfull.');
        endif;
    }
}

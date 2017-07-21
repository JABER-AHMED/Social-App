<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Session;

class UserController extends Controller
{

    public function postSignUp(Request $request)
    {
    	$this->validate($request, array(

            'email' => 'email|unique:users|required',
            'first_name' => 'required|max:30'

        ));

        $useremail = User::where('email', $request->email)->first();
        $username = User::where('first_name', $request->first_name)->first();

        if ($useremail) {
            Session::flash('danger', 'Email has already taken');
            return redirect()->back();
        }else if($username){

            Session::flash('danger', 'FirstName has alredy taken');
            return redirect()->back();
        }else{

    	$user = new User();

    	$user->email = $request->email;
    	$user->first_name = $request->first_name;
    	$user->password = bcrypt($request->password);
    	$user->confirm_password = bcrypt($request->confirm_password);

    	$user->save();
        Session::flash('success', 'Successfully Registered User');
        Auth::login($user);

    	return redirect()->route('dashboard');
        }

    }
    public function postSignIn(Request $request)
    {
        $this->validate($request, array(

            'email' => 'required',
            'password' => 'required'

        ));

    	if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){

    		return redirect()->route('dashboard');
    	}
    	else{
    		return redirect()->back();
    	}
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request, array(

            'first_name' => 'required|max:50'
        ));

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->update();
        $file = $request->file('image');
        $filename = $request->first_name . '-'. $user->id. '.jpg';
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new response($file, 200);
    }
}

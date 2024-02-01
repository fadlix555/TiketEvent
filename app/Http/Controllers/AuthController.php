<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postregister(request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);
        
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back();
        }        

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user'
        ]);
        return redirect()->route('login')->with('notif', 'Berhasil registrasi silahkan login');
    }

    public function postlogin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Invalid field');
        }

        if(!Auth::attempt($request->only(['nama', 'password']))){

            return redirect()->back()->with('error', 'Username atau Password salah!');
        }

        $user = Auth::user();
        if ($user->role === 'admin'){
            return redirect()->route('admin');
        } else if ($user->role === 'kasir') {
            return redirect()->route('orders');
        } else if ($user->role === 'owner') {
            return redirect()->route('riwayat');
        } else {
            return redirect()->route('welcome')->with('notif', 'Berhasil Login');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('welcome');
    }
}

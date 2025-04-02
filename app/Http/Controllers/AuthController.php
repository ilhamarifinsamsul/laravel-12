<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm() {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request) {
        $user = User::where('name', $request->name)->first();

        if ($user == null) {
            return redirect()->back()->with('error', "user tidak ditemukan");
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with("error", "Password Salah!!");
        }

        $request->session()->regenerate();
        $request->session()->put('isLogged', true);
        $request->session()->put('id', $user->id);

        return redirect()->route('products.index');
        // $credentials = $request->validate([
        //     'name' => 'required|string',
        //     'password' => 'require|string'
        // ]);

        // if (User::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('products.index');
        // }

        // return back()->withErrors([
        //     'name' => 'Name atau password salah.'
        // ])->onlyInput('name');
    }

    // proses logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

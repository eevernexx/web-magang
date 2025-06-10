<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        // if(Auth::check()){
        //     return redirect('/dashboard');
        // }
        return view('pages.auth.login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;
            if ($userStatus == 'submitted') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda masih menunggu persetujuan admin',
                ])->withInput();
            } elseif ($userStatus == 'rejected') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda telah ditolak admin',
                ])->withInput();
            }

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan, periksa kembali email atau password anda.',
        ])->withInput();
    }


    public function registerView(){
        
        if(Auth::check()){
            return back();
        }
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return back();
        }

        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'university' => ['required'],
            'field_of_study' => ['required'],
            'bidang' => ['required'],
            'profile_picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'surat_validasi' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ]);

        // Simpan file ke storage
        $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        $suratPath = $request->file('surat_validasi')->store('surat_validasi', 'public');

        // Buat user baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->university = $request->university;
        $user->field_of_study = $request->field_of_study;
        $user->bidang = $request->bidang;
        $user->profile_picture = $profilePath;
        $user->surat_validasi = $suratPath;
        $user->role_id = 2; // misal role "user"
        $user->status = 'submitted';
        $user->save();

        // Tidak perlu login otomatis karena status masih submitted
        return redirect('/')->with('success', 'Pendaftaran berhasil! Silakan tunggu persetujuan admin.');
    }


    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
    }

    public function logout(Request $request)
    {
        if(!Auth::check()){
            return redirect('/');
        }
        $this -> _logout($request);
        
        return redirect('/');
    }
}

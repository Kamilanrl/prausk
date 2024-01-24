<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function store(Request $request)
    {
        if ($request->confirm_password == $request->password) {
            $user = User::create([
                'name'=>$request->name,
                'username'=>$request->username,
                'password'=>Hash::make($request->password),
                'role'=>$request->role,
            ]);
            if ($user) {
                return redirect()->back()->with('status','Berhasil');
            }
            return redirect()->back()->with('status','Gagal');
        }
    }

    public function update(Request $request, string $id)
    {
        $check = $user::withTrashed()->where('username',$request->$username)->first();
        if ($check && $request->username == User::find($user)->username) {
            return redirect()->back()->with('status','Username sudah digunakan');
        }else {
            if ($request->confirm_password == $request->password) {
                $data=[
                    'name'=>$request->name,
                    'username'=>$request->username,
                    'role'=>$request->role,
                ];

                if ($request->password != '') {
                    $data['password'] = Hash::make($request->password);
                }

                $user = User::find($user)->update($data);
            }
        }
    }
}

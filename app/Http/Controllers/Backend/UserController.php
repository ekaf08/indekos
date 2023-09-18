<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    public function profil()
    {
        $profil = auth()->user();

        return view('backend.user.update_profil', compact('profil'));
    }

    public function updateprofil(Request $request)
    {
        $profil = auth()->user();

        if (!empty($request->password)) {
            $validator = Validator::make($request->all(), [
                'confirm_password' => 'required',
                'old_password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Data gagal disimpan'
                ], 422);
            }

            if (Hash::check($request->old_password, $profil->password)) {
                if ($request->password == $request->confirm_password) {
                    $profil->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
                // return back()->with('error', 'Password lama tidak sesuai');
            }
        }

        $profil->name = $request->name;
        $profil->address = $request->address;
        $profil->phone = $request->phone;
        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $nama = 'profil-' . $profil->name . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $nama);

            $profil->path_image = "/img/$nama";
        }
        $profil->update();

        return response()->json([
            'data' => $profil,
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUsers;

class UserController extends Controller
{
    public function index()
    {
        $getSubMenu = Roles::getSubMenu();
        if ($getSubMenu) {
            return view('error.404');
        }

        $url = 'user.index';
        $data['getAkses'] = Roles::getAkses($url);
        $data['getRole'] = Roles::orderBy('nama', 'asc')->get();

        return view('backend.user.index', $data);
    }

    public function data()
    {
        $data = User::getUser();
        return datatables($data)
            ->addIndexColumn()
            ->editColumn('nama', function ($data) {
                return ucwords($data->name);
            })
            ->editColumn('path_image', function ($data) {
                return '<a href="javascript:void(0);" id="btn_zoom_img" class="btn border-0 btn_zoom" data-img="' . url(Storage::disk('local')->url($data->path_image)) . '" data-nama="' . ucwords($data->name) . '"> 
                         <img src="' . url(Storage::disk('local')->url($data->path_image)) . '" class="rounded mx-auto d-block" width="45px" height="45px">
                        </a>';
            })
            ->editColumn('address', function ($data) {
                $address = ucwords($data->address);
                $limit = mb_strimwidth($address, 0, 120, '...');
                return $limit;
            })
            ->addColumn('action', function ($data) {
                $url = 'user.index';
                $getAkses = Roles::getAkses($url);
                if ($getAkses->update == 't') {
                    $update = '<button type="button" class="btn btn-link text-primary" onclick="editForm(`' . route('user.update', encrypt($data->id)) . '`)" title="Edit- `' . $data->nama . '`"><i class="bi bi-pencil-square"></i></button>';
                } elseif ($getAkses->update != 't') {
                    $update = '';
                }

                if ($getAkses->delete == 't') {
                    $delete = ' <button type="button" class="btn btn-link text-danger" onclick="deleteData(`' . route('user.destroy', encrypt($data->id)) . '`)" title="Hapus- `' . $data->nama . '`"><i class="bi bi-trash3"></i></button>';
                } elseif ($getAkses->delete != 't') {
                    $delete = '';
                }

                $action = '
                <div class="text-center">
                    ' . $update . '
                ' . $delete . '
                </div>
            ';
                return $action;
            })
            ->rawColumns(['action', 'nama', 'address', 'path_image'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users,email',
            'id_role' => 'required',
            'phone' => 'required', 'regex:/^((71)|(73)|(77))[0-9]{7}/',
            'address' => 'nullable|min:10',
            'path_image' => 'mimes:png,jpg,jpeg|max:1048',
            'password' => 'required',
        ]);

        // dd($request->path_image, $request->all(), $request->file('path_image'));

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Data gagal disimpan'
            ], 422);
        }

        $data['name'] = $request->name;
        $data['username'] = $request->name;
        $data['id_role'] = $request->id_role;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['password'] = bcrypt($request->password);
        $data['updated_by'] = auth()->user()->name;
        $data['path_image'] = upload('profil_img', $request->file('path_image'), 'profil-' . $request->name);

        $user = User::create($data);
        return response()->json([
            'data' => $user,
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function xlsx()
    {
        $date = date('d-m-Y');
        return Excel::download(new ExportUsers, 'user_' . $date . '.xlsx');
    }

    public function getEmail(Request $request)
    {
        $email = $request->input('email');
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email',
        ]);
        $user = User::where('email', $email)->first();

        if ($user) {
            $exists = true;
        } else {
            // Email belum terdaftar
            $exists = false;
        }
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'exists' => $exists
            ]);
        }
        // return response()->json(['exists' => $exists]);
    }

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

        $profil->updated_by = auth()->user()->name;
        $profil->name = $request->name;
        $profil->address = $request->address;
        $profil->phone = $request->phone;
        if ($request->hasFile('path_image')) {
            $validator = Validator::make($request->all(), [
                'path_image' => 'nullable|mimes:png,jpg,jpeg|max:1048',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Data gagal disimpan'
                ], 422);
            } else {
                $profil->path_image = upload('profil_img', $request->file('path_image'), 'profil-' . auth()->user()->name);
            }
        }
        $profil->update();

        return response()->json([
            'data' => $profil,
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }
}

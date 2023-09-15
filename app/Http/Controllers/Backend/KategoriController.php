<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Roles;
use App\Models\RoleSubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.kategori.index');
    }

    public function data()
    {
        $query = Kategori::orderBy('id', 'desc')->get();
        // dd($query);

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('nama', function ($query) {
                return ucwords($query->nama);
            })
            ->addColumn('action', function ($query) {
                $role = Roles::with(['menu' => function ($query) {
                    $query->with('menu_detail');
                    $query->with('sub_menu.sub_menu_detail');
                }])->where('id', Auth::user()->id_role)->first();
                $routeName = RoleSubMenu::leftJoin('role_menu', 'role_menu.id', 'role_sub_menu.id_sub_menu')
                    ->select('role_sub_menu.id_sub_menu')
                    ->where('id_role', Auth::user()->id_role)->first();
                $routeId = $routeName->id_sub_menu;

                foreach ($role->menu as $menu) {
                    foreach ($menu->sub_menu as $sub_menu) {
                        // dd($sub_menu);
                        if ($sub_menu->id_sub_menu ==  $routeId && $sub_menu->update == 't') {
                            $update = '<button type="button" class="btn btn-link text-primary" onclick="editForm(`' . route('kategori.update', encrypt($query->id)) . '`)" title="Edit- `' . $query->nama . '`"><i class="bi bi-pencil-square"></i></button>';
                        } elseif ($sub_menu->id_sub_menu == $routeId && $sub_menu->update != 't') {
                            $update = '';
                        }

                        if ($sub_menu->id_sub_menu == $routeId && $sub_menu->delete == 't') {
                            $delete = ' <button type="button" class="btn btn-link text-danger" onclick="deleteData(`' . route('kategori.destroy', encrypt($query->id)) . '`)" title="Hapus- `' . $query->nama . '`"><i class="bi bi-trash3"></i></button>';
                        } elseif ($sub_menu->id_sub_menu == $routeId && $sub_menu->delete != 't') {
                            $delete = '';
                        }
                    }
                }

                $action = '
                    <div class="">
                        ' . $update . '
                    ' . $delete . '
                    </div>
                ';
                return $action;
            })
            ->rawColumns(['action', 'nama'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:kategori,nama|min:4|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Data gagal disimpan'
            ], 422);
        }

        $data = $request->only('nama');
        $data['slug'] = Str::slug($request->nama);
        $kategori = Kategori::create($data);

        // Response
        return response()->json([
            'data' => $kategori,
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = decrypt($id);
        $kategori = Kategori::where('id', $id)->first();
        return response()->json(['data' => $kategori]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $kategori = Kategori::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:kategori,nama|min:4|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only('nama');
        $data['slug'] = Str::slug($request->nama);
        $kategori->update($data);

        return response()->json([
            'data' => $kategori,
            'success' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $kategori = Kategori::where('id', $id)->first();
        $kategori->delete();
        return response()->json(['data' => null, 'message' => 'Kategori berhasil dihapus', 'success' => true]);
    }
}

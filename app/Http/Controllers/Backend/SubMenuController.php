<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\SubMenu;
use App\Models\RoleSubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $subMenu = SubMenu::all();
        // return view('backend.setup.index', compact('subMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_menu' => 'required|max:255',
            'url' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Data gagal disimpan'
            ], 422);
        }

        $id_menu = decrypt($request->id_master_menu);
        $menu =  Menu::find($id_menu);
        $roleMenu = RoleMenu::where('id_menu', $id_menu)->get();
        // dd($roleMenu);

        $data['id_menu']    = $id_menu;
        $data['sub_menu']   = $request->sub_menu;
        $data['url']        = $request->url;
        $data['icon']       = $request->sub_menu;
        $data['active']     = $request->sub_menu;
        $data = SubMenu::create($data);
        $id_sub_menu    = $data->id;
        $sub_menu       = $data->sub_menu;

        foreach ($roleMenu as $key => $value) {
            $data2 = new RoleSubMenu;
            $data2['id_role_menu']  = $value->id;
            $data2['as_menu']       = $value->as_menu;
            $data2['id_sub_menu']   = $id_sub_menu;
            $data2['as_sub_menu']   = $sub_menu;
            $data2['select']   = 'true';
            $data2['insert']   = 'true';
            $data2['update']   = 'true';
            $data2['delete']   = 'true';
            $data2['import']   = 'false';
            $data2['export']   = 'false';
            $data2->save();
        }

        return redirect()->route('setup.index')->with([
            'message'   => 'Sub Menu berhasil ditambahkan',
            'success'   => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $id = decrypt($id);
        $submenu = SubMenu::where('id', $id)->first();
        return response()->json(['data' => $submenu]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $validator = Validator::make($request->all(), [
            'sub_menu' => 'required|max:255',
            'url' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Data gagal disimpan'
            ], 422);
        }

        $submenu = SubMenu::where('id', $id)->first();
        $data['sub_menu'] = $request->sub_menu;
        $data['url'] = $request->url;
        $submenu->update($data);

        $role_sub_menu = RoleSubMenu::where('id_sub_menu', $id)->get();
        foreach ($role_sub_menu as $key => $value) {
            $data_rsm = RoleSubMenu::where('id_sub_menu', $id)->first();
            $data_rsm['as_sub_menu'] = $request->sub_menu;
            $data_rsm->update();
        }

        return redirect()->route('setup.index')->with([
            'message'   => 'Sub Menu berhasil diperbarui',
            'success'   => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = decrypt($id);
        $sub_menu = SubMenu::where('id', $id)->first();
        $sub_menu->delete();

        $role_sub_menu = RoleSubMenu::where('id_sub_menu', $id)->get();
        foreach ($role_sub_menu as $key => $value) {
            $data_rsm = RoleSubMenu::where('id_sub_menu', $id)->first();
            $data_rsm['select']   = 'false';
            $data_rsm['insert']   = 'false';
            $data_rsm['update']   = 'false';
            $data_rsm['delete']   = 'false';
            $data_rsm['import']   = 'false';
            $data_rsm['export']   = 'false';
            $data_rsm->update();

            $data_rsm->delete();
        }
        return response()->json(['data' => null, 'message' => 'Sub Menu Berhasil Dihapus.', 'success' => true]);
    }
}

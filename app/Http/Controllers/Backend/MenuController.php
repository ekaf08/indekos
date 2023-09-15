<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\Roles;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use App\Models\SubMenu;
use App\Models\RoleSubMenu;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $date =
            $validated = $request->validate([
                'menu' => 'required|unique:menu,menu|min:4|max:255',
            ]);

        // insert untuk tabel menu
        $data['menu'] = $request->menu;
        $data['icon'] = $request->icon;
        $data['active'] = Str::slug($request->menu);
        $data = Menu::create($data);
        $id_new = $data->id;
        $menu_new = $data->menu;
        //End insert untuk tabel menu

        // insert untuk tabel role_menu
        $max_number = RoleMenu::where('id_role', '2')->max("sort") + 1;

        $role_menu = Roles::leftJoin('role_menu', 'role_menu.id_role', 'roles.id')
            ->select('roles.id', 'role_menu.id_role', 'roles.nama')
            ->distinct()
            ->get();
        $date = Carbon::now()->format('d-m-Y');

        foreach ($role_menu as $key => $value) {
            $data = new RoleMenu;
            $data['id_role'] = $value->id_role;
            $data['as_role'] = $value->nama;
            $data['id_menu'] = $id_new;
            $data['as_menu'] = $menu_new;
            $data['sort']    = $max_number;
            $data['select']  = 'true';
            $data->save();
        }
        // End insert untuk tabel role_menu

        // update urutan Menu pengaturan
        $urut = RoleMenu::where('id_role', '1')->max("sort") + 1;
        $up_urutan = RoleMenu::where('id', '3')->first();
        $up_urutan['sort'] = $urut;
        $up_urutan->update();
        // end update urutan Menu pengaturan

        return redirect()->route('setup.index')->with([
            'message'   => 'Menu berhasil ditambahkan',
            'success'   => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = decrypt($id);
        $menu = Menu::where('id', $id)->first();
        return response()->json(['data' => $menu]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $validator = Validator::make($request->all(), [
            'menu' => 'required|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Data gagal disimpan'
            ], 422);
        }

        $menu = Menu::where('id', $id)->first();
        $data['menu'] = $request->menu;
        $data['icon'] = $request->icon;
        $data['active'] = Str::slug($request->menu);
        $menu->update($data);

        $role_menu = RoleMenu::where('id_menu', $id)->get();
        foreach ($role_menu as $key => $value) {
            $role_menu_up = RoleMenu::where('id_menu', $id)->first();
            $role_menu_up['as_menu'] = $request->menu;
            $role_menu_up->update();
        }

        return redirect()->route('setup.index')->with([
            'message'   => 'Menu berhasil diperbarui',
            'success'   => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = decrypt($id);
        $menu = Menu::where('id', $id)->first();
        $menu->delete();

        $role_menu = RoleMenu::where('id_menu', $id)->get();
        $id_role_menu = $role_menu->id;
        // foreach ($role_menu as $key => $value) {
        //     $data_rm = RoleMenu::where('id_menu', $id)->first();
        //     $data_rm['select']   = 'false';
        //     $data_rm['insert']   = 'false';
        //     $data_rm['update']   = 'false';
        //     $data_rm['delete']   = 'false';
        //     $data_rm['import']   = 'false';
        //     $data_rm['export']   = 'false';
        //     $data_rm->update();

        //     $data_rm->delete();
        // }

        // $sub_menu = SubMenu::where('id_menu', $id)->get();
        // $id_sub_menu = $sub_menu->id;
        // foreach ($sub_menu as $key => $value) {
        //     $sub_menu_delete = SubMenu::where('id_menu', $id)->first();
        //     $sub_menu_delete->delete();
        // }

        // $role_sub_menu = RoleSubMenu::where('id_sub_menu', $id_sub_menu)->get();
        // foreach ($role_sub_menu as $key => $value) {
        //     $data_rsm = RoleSubMenu::where('id_sub_menu', $id_role_menu)->first();
        //     $data_rsm['select']   = 'false';
        //     $data_rsm['insert']   = 'false';
        //     $data_rsm['update']   = 'false';
        //     $data_rsm['delete']   = 'false';
        //     $data_rsm['import']   = 'false';
        //     $data_rsm['export']   = 'false';
        //     $data_rsm->update();

        //     $data_rsm->delete();
        // }

        return response()->json(['data' => null, 'message' => 'Menu Berhasil Dihapus.', 'success' => true]);
    }
}

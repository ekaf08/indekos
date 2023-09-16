<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\Roles;
use App\Models\RoleSubMenu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class AppMenuController extends Controller
{
    public function index()
    {
        $lala = Menu::orderBy('id', 'asc')->get();
        $subMenu = SubMenu::orderBy('id', 'asc')->get();
        return view('backend.setup.index', compact('lala', 'subMenu'));
    }

    public function data()
    {
        $query = Roles::orderBy('id', 'asc')->get();


        return dataTables($query)
            ->addIndexColumn()
            ->editColumn('nama', function ($query) {
                $nama = ucwords($query->nama);
                return $nama;
            })
            ->addColumn('action', function ($query) {
                $role = Roles::with(['menu' => function ($query) {
                    $query->with('menu_detail');
                    $query->with('sub_menu.sub_menu_detail');
                }])->where('id', Auth::user()->id_role)->first();

                $curentUrl = 'setup.index';

                foreach ($role->menu as $menu) {
                    foreach ($menu->sub_menu as $sub_menu) {
                        // dd($sub_menu->sub_menu_detail->id_sub_menu, $menu);
                        if ($sub_menu->sub_menu_detail->url == $curentUrl && $sub_menu->update == 't') {
                            $update = '<button type="button" class="btn btn-link text-primary" onclick="editForm(`' . route('setup.show', encrypt($query->id)) . '`, `Edit Role ' . $query->nama . '`, `' . encrypt($query->id) . '`)" title="Edit- `' . $query->nama . '`"><i class="bi bi-gear-wide-connected"></i></button>';
                        } elseif ($sub_menu->sub_menu_detail->url == $curentUrl && $sub_menu->update != 't') {
                            $update = '';
                        }

                        if ($sub_menu->sub_menu_detail->url == $curentUrl && $sub_menu->delete == 't') {
                            $delete = '<button type="button" class="btn btn-link text-danger" onclick="deleteData(`' . route('setup.destroy', encrypt($query->id)) . '`, `Role ' . $query->nama . '`)" title="Hapus- `' . $query->nama . '`"><i class="bi bi-trash3"></i></button>';
                        } elseif ($sub_menu->sub_menu_detail->url == $curentUrl && $sub_menu->delete != 't') {
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
            ->escapeColumns([])
            ->make(true);
    }

    // Start datatable menu
    public function menu(Request $request)
    {
        // dd(decrypt($request->id_role));
        $menu = RoleMenu::leftJoin('roles', 'roles.id', 'role_menu.id_role')
            ->leftJoin('menu', 'menu.id', 'role_menu.id_menu')
            ->where('roles.id', decrypt($request->id_role))
            ->select('roles.id as role_id', 'menu.id as menu_id', 'menu.menu as nama_menu', 'role_menu.*')
            ->orderBy('role_menu.sort', 'asc')
            ->withTrashed()
            ->get();

        return datatables($menu)
            ->addIndexColumn()
            ->editColumn('nama_menu', function ($menu) {
                $nama_menu = ucwords($menu->nama_menu);
                return $nama_menu;
            })
            ->editColumn('deleted_at', function ($menu) {
                $checked = $menu->deleted_at ? '' : 'checked';
                return ' 
                <label class="container">
                    <input type="checkbox" name="is_active_menu[]" id="is_active_menu[]" data-id="' . encrypt($menu->id) . '" value=""  ' . $checked . '>
                    <span class="checkmark"></span>
                </label>
                   
                ';
            })
            ->addColumn('action', function ($menu) {
                if ($menu->deleted_at == '') {
                    $panah = '
                    <button type="button" class="btn btn-link text-success" id="atas" data-urutan="' . $menu->sort . '" data-id="' . encrypt($menu->id) . '"><i class="bi bi-arrow-up"></i></button>
                    <button type="button" class="btn btn-link text-success" id="bawah" data-urutan="' . $menu->sort . '" data-id="' . encrypt($menu->id) . '"><i class="bi bi-arrow-down"></i></button>
                ';
                } else {
                    $panah = '';
                }

                $urutan = '<input type="text" class="form-control text-center" name="urutan" id="urutan" value="' . $menu->sort . '" data-id="' . encrypt($menu->id) . '">';
                return $panah;
            })
            ->addColumn('add_subMenu', function ($menu) {
                if ($menu->menu_id != 1) {
                    $add_subMenu = '
                    <button type="button" class="btn btn-link text-primary" id="addSubMenu" onclick="add_SubMenu(`' . route('setup.addSubMenu', encrypt($menu->id)) . '`)" data-urutan="' . $menu->sort . '" data-id="' . encrypt($menu->id) . '" title="Tambah Submenu ' . ucwords($menu->nama_menu) . '"><i class="bi bi-file-earmark-plus"></i></button>
                ';
                } else {
                    $add_subMenu = '';
                }
                return $add_subMenu;
            })
            ->rawColumns(['deleted_at', 'action', 'nama_menu', 'add_subMenu'])
            ->escapeColumns([])
            ->make(true);
    }
    // End datatable menu

    public function urutanMenu(Request $request)
    {
        $id         = decrypt($request->id);
        $direction  = $request->direction;

        $item = RoleMenu::find($id);
        $currentSort    = $item->sort;
        $currentRole    = $item->id_role;
        // dd($currentRole, $currentSort);

        if ($direction == 'up') {
            // untuk urutan atas atau panah atas
            $itemUp = RoleMenu::where('sort', '<', $currentSort)
                ->where('id_role', $currentRole)
                ->orderBy('sort', 'desc')
                ->first();
            if ($itemUp) {
                $item->sort = $itemUp->sort;
                $itemUp->sort = $currentSort;
                $item->save();
                $itemUp->save();
            }
        }
        // untuk urutan bawah atau panah bawah 
        elseif ($direction == 'down') {
            // dd($currentRole);
            $condition = RoleMenu::select('sort')
                ->where('id_role', $currentRole)
                ->whereNull('deleted_at')
                ->orderBy('sort', 'desc')
                ->get()
                ->toArray();

            if ($currentSort == $condition[0]['sort']) {
                return response()->json(['message' => 'Menu sudah di paling akhir.', 'success' => false]);
            }
            $itemDown = RoleMenu::where('sort', '>', $currentSort)
                ->where('id_role', $currentRole)
                ->orderBy('sort', 'desc')
                ->first();
            if ($itemDown) {
                $item->sort = $itemDown->sort;
                $itemDown->sort = $currentSort;
                $item->save();
                $itemDown->save();
            }
        }

        return response()->json(['message' => 'Menu Berhasil Diperbarui', 'success' => true]);
    }

    public function addSubMenu(Request $request, $id)
    {
        $id = decrypt($id);

        $menu = Menu::find($id);
        dd($menu);
    }

    public function hapus_menu(Request $request)
    {
        $id = decrypt($request->id);
        $data = RoleMenu::where('id', $id)->first();
        $data->delete();
        return response()->json([
            'data' => null,
            'message' => 'Menu Berhasil Di Non Aktifkan',
            'success' => true
        ]);
    }

    public function restore_menu(Request $request)
    {
        $id = decrypt($request->id);
        $data = RoleMenu::withTrashed()->find($id);
        $data->restore();
        return response()->json([
            'data' => null,
            'message' => 'Menu Berhasil Di Aktifkan',
            'success' => true
        ]);
    }

    // Start datatable sub menu
    public function subMenu(Request $request)
    {
        $query = Roles::distinct()
            ->select(
                'roles.nama',
                'roles.id',
                'sub_menu.sub_menu as nama_sub_menu',
                'role_sub_menu.*'
            )
            ->leftJoin('role_menu', 'roles.id', 'role_menu.id_role')
            ->join('role_sub_menu', 'role_menu.id', 'role_sub_menu.id_role_menu')
            ->leftJoin('sub_menu', 'sub_menu.id', 'role_sub_menu.id_sub_menu')
            ->where('roles.id', decrypt($request->id_role))
            ->withTrashed()
            ->orderBy('role_sub_menu.id_sub_menu', 'asc')
            ->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('nama_sub_menu', function ($query) {
                $nama_sub_menu = ucwords($query->nama_sub_menu);
                return $nama_sub_menu;
            })
            ->editColumn('select', function ($query) {
                $checked = $query->select ? 'checked' : '';
                return '
                <label class="container">
                    <input type="checkbox" name="is_active[]" id="is_active" data-id="' .  encrypt($query->id) . '" data-kolom="select" value=""  ' . $checked . '>
                    <span class="checkmark"></span>
                </label>
                
                ';
            })
            ->editColumn('insert', function ($query) {
                $checked = $query->insert ? 'checked' : '';
                return '
                <label class="container">
                    <input type="checkbox" name="is_active[]" id="is_active" data-id="' .  encrypt($query->id) . '" data-kolom="insert" value="" ' . $checked . '>
                    <span class="checkmark"></span>
                </label>
                ';
            })
            ->editColumn('update', function ($query) {
                $checked = $query->update ? 'checked' : '';
                return '
                <label class="container">
                    <input type="checkbox" name="is_active[]" id="is_active" data-id="' .  encrypt($query->id) . '" data-kolom="update" value=""  ' . $checked . '>
                    <span class="checkmark"></span>
                </label>
                ';
            })
            ->editColumn('delete', function ($query) {
                $checked = $query->delete ? 'checked' : '';
                return '
                <label class="container">
                    <input type="checkbox" name="is_active[]" id="is_active" data-id="' .  encrypt($query->id) . '" data-kolom="delete" value=""  ' . $checked . '>
                    <span class="checkmark"></span>
                </label>
                ';
            })
            ->editColumn('export', function ($query) {
                $checked = $query->export ? 'checked' : ':not(:checked)';
                return '
                <label class="container">
                    <input type="checkbox" name="is_active[]" id="is_active" data-id="' .  encrypt($query->id) . '" data-kolom="export" value=""  ' . $checked . '>
                    <span class="checkmark"></span>
                </label>
                ';
            })
            ->editColumn('import', function ($query) {
                $checked = $query->import ? 'checked' : '';
                return '
                <label class="container">
                    <input type="checkbox" name="is_active[]" id="is_active" data-id="' .  encrypt($query->id) . '" data-kolom="import" value=""  ' . $checked . '>   
                    <span class="checkmark"></span>
                </label>
                ';
            })
            ->addColumn('action', function ($query) {
                if ($query->deleted_at != null && $query->deleted_at != '') {
                    return ' <button type="button" class="btn btn-link text-warning" onclick="restoreData(`' . route('setup.restore_subMenu', encrypt($query->id)) . '`, `Menu ' . $query->nama_sub_menu . '`)" title="Aktifkan- `' . $query->nama_sub_menu . '`"><i class="bi bi-arrow-counterclockwise"></i></button>';
                } else {
                    return ' <button type="button" class="btn btn-link text-danger" onclick="deleteData(`' . route('setup.hapus_subMenu', encrypt($query->id)) . '`, `Menu ' . $query->nama_sub_menu . '`)" title="Hapus- `' . $query->nama_sub_menu . '`"><i class="bi bi-trash3"></i></button>';
                }
            })
            ->rawColumns(['select', 'insert', 'update', 'delete', 'export', 'import', 'action', 'nama_sub_menu'])
            ->escapeColumns([])
            ->make(true);
    }
    // End datatable sub menu

    public function configMenu(Request $request)
    {
        $this->validate($request, [
            'is_active' => 'boolean'
        ]);
        try {
            $sub_menu = RoleSubMenu::where('id', decrypt($request->id))->withTrashed()->first();
            if (!empty($sub_menu->deleted_at)) {
                $sub_menu->restore();
            }
            $kolom = $request->kolom;
            $sub_menu->$kolom = $request->boolean('value');
            $sub_menu->save();

            return response()->json(['data' => $sub_menu, 'message' => 'Sub Menu Berhasil Diperbarui', 'success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Mohon maaf telah terjadi kesalahan. Aktifkan sub menu'], 500);
        }
    }

    public function hapus_subMenu($id)
    {
        $id = decrypt($id);
        $menu = RoleSubMenu::where('id', $id)->first();
        $menu->select = 'false';
        $menu->insert = 'false';
        $menu->update = 'false';
        $menu->delete = 'false';
        $menu->import = 'false';
        $menu->export = 'false';
        $menu->save();
        $menu->delete();
        return response()->json([
            'data' => null,
            'message' => 'Sub Menu Berhasil Dihapus',
            'success' => true
        ]);
    }

    public function restore_subMenu(Request $request)
    {
        $id = decrypt($request->id);
        $data = RoleSubMenu::withTrashed()->find($id);
        $data->restore();
        $data->select = 'true';
        $data->insert = 'true';
        $data->update = 'true';
        $data->delete = 'true';
        $data->import = 'false';
        $data->export = 'false';
        $data->save();
        return response()->json([
            'data' => null,
            'message' => 'Sub Menu Berhasil Di Aktifkan',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:roles,nama|min:4|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = new Roles;
        $data['nama'] = $request->nama;
        $data->save();
        $role_id = $data->id;
        $nama_role = $data->nama;

        // start menambahkan role menu
        $role_menu = RoleMenu::leftJoin('menu', 'menu.id', 'role_menu.id_menu')
            ->where('role_menu.id_role', '2')
            ->orderBy('menu.id')
            ->get();

        foreach ($role_menu as $key => $value) {
            $data = new RoleMenu;
            $data['id_role'] = $role_id;
            $data['as_role'] = $nama_role;
            $data['id_menu'] = $value->id;
            $data['as_menu'] = $value->menu;
            $data['sort'] = $value->sort;
            $data->save();
        }
        // End menambahkan role menu

        // start menambahkan role sub menu
        $role_sub_menu = SubMenu::leftJoin('menu', 'sub_menu.id_menu', 'menu.id')
            ->select('sub_menu.*', 'role_menu.id as id_role_menu', 'menu.menu as menu')
            ->leftJoin('role_menu', 'role_menu.id_menu', 'menu.id')
            ->where('role_menu.id_role', $role_id)
            ->orderBy('menu.id', 'asc')
            ->get();

        // dd($role_sub_menu->toArray());
        foreach ($role_sub_menu as $key => $value) {
            $data = new RoleSubMenu;
            $data['id_role_menu'] = $value->id_role_menu;
            $data['as_menu'] = $value->menu;
            $data['id_sub_menu'] = $value->id;
            $data['as_sub_menu'] = $value->sub_menu;
            $data['select'] = 'true';
            $data['insert'] = 'true';
            $data->save();
        }
        // End menambahkan role sub menu


        // Response
        return response()->json([
            'data' => $data,
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function show($id)
    {
        $id = decrypt($id);

        $role = Roles::where('id', $id)->first();

        return response()->json(['data' => $role]);
    }

    function showSubMenu(Request $request)
    {
        // dd($request->all(), decrypt($request->id));
        $id = decrypt($request->id);
        // dd($id);
        $data = SubMenu::where('id_menu', $id)->orderBy('id', 'asc')->get();

        return datatables($data)
            ->addIndexColumn()
            ->editColumn('sub_menu', function ($data) {
                $sub_menu = ucwords($data->sub_menu);
                return $sub_menu;
            })
            ->addColumn('action', function ($data) {
                $edit =
                    '<button type="button" class="btn btn-link text-primary" onclick="editSubMenu(`' . route('submenu.update', encrypt($data->id)) . '`, `Edit Sub Menu - ' . $data->sub_menu . '`, `' . $data->sub_menu . '`, `' . encrypt($data->id) . '`)" title="Edit- `' . $data->sub_menu . '`">
                        <i class="bi bi-pencil-square"></i>
                    </button>';
                $delete =
                    '<button type="button" class="btn btn-link text-danger" onclick="deleteData(`' . route('submenu.destroy', encrypt($data->id)) . '`, `Submenu ' . $data->sub_menu . '`)" title="Hapus- `' . $data->sub_menu . '`">
                        <i class="bi bi-trash3"></i>
                    </button>';
                $button =
                    '<div>
                        ' . $edit . '
                        ' . $delete . '
                    </div>';
                return $button;
            })
            ->rawColumns(['sub_menu', 'action'])
            ->escapeColumns([])
            ->make(true);
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $role = Roles::where('id', $id)->first();
        $role->delete();
        return response()->json([
            'data' => null,
            'message' => 'Role Berhasil Dihapus',
            'success' => true
        ]);
    }
}

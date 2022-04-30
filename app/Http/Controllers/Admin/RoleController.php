<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:role.view')->only('index');
        $this->middleware('can:role.create')->only(['create', 'store']);
        $this->middleware('can:role.edit')->only(['edit', 'update']);
        $this->middleware('can:role.delete')->only('destroy');
    }

    public function getRoles () {
        $scanDir = scandir(__DIR__);
        $file = array_diff($scanDir, ['.', '..']);
        $controller = array_map(function ($item) {
            return strtolower(str_replace('Controller.php', '', $item));
        }, $file);


        $roles = [];
        if ( !empty($controller) ) {
            $index = 0;
            foreach ($controller as $key => $name) {
                foreach (Role::$action as $action) {
                    $roles[$name][$index] = "$name.$action";
                    $index++;
                }
            }
        }
        return $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('admin.role.index');
    }

    public function dataTable ()
    {
        return Role::buildDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->getRoles();
        return view('admin.role.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3',
            'desc' => 'string|nullable',
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'title.min' => 'Tiêu đề phải có tối thiểu 3 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new Role();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        $permission = $request->input('permission');
        if (!empty($permission)) {
            $dataInsert = [];
            foreach ($permission as $key => $item) {
                $dataInsert[$key]['role_id'] = $model->id;
                $dataInsert[$key]['code'] = $item;
            }
        }

        $insert = Permission::query()->insert($dataInsert);
        if (!$insert) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        return redirect()->route('role.edit', $model->id)->with('success', 'Tạo nhóm quyền thành công');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Role::query()->findOrFail($id);
        $roles = $this->getRoles();

        $permission = [];
        foreach ($group->permission as $key => $item) {
            $permission[$key] = $item->code;
        }
        return view('admin.role.edit', [
            'group' => $group,
            'roles' => $roles,
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3',
            'desc' => 'string|nullable',
        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'title.min' => 'Tiêu đề phải có tối thiểu 3 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Role::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();

        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        $permission = $request->input('permission');
        Permission::query()->where([
            'role_id' => $model->id
        ])->delete();

        if (!empty($permission)) {
            $dataInsert = [];
            foreach ($permission as $key => $item) {
                $dataInsert[$key]['role_id'] = $model->id;
                $dataInsert[$key]['code'] = $item;
            }
        }

        $insert = Permission::query()->insert($dataInsert);
        if (!$insert) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        return redirect()->route('role.edit', $model->id)->with('success', 'Câp nhật nhóm quyền thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $role = Role::find($id);
            $delete = $role->delete();
            if (!$delete) {
                return response()->json([
                    'type' => 'error',
                    'code' => 500,
                    'message' => 'Có lỗi xảy ra'
                ]);
            }

            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Xóa bản ghi thành công'
            ]);
        }
        return response()->json([
            'type' => 'error',
            'code' => 500,
            'message' => 'Có lỗi xảy ra'
        ]);
    }
}

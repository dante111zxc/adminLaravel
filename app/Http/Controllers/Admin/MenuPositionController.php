<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuPosition;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Utils;

class MenuPositionController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:menuposition.view')->only('index');
        $this->middleware('can:menuposition.create')->only(['create', 'store']);
        $this->middleware('can:menuposition.edit')->only(['edit', 'update']);
        $this->middleware('can:menuposition.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.menu-position.index');
    }

    public function dataTable (){
        return MenuPosition::buildDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu-position.create');
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
            'title' => "required",
            'position' => 'required|unique:menu_positions,position',

        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'position.required' => 'Vị trí không được bỏ trống',
            'position.unique' => 'Vị trí đã tồn tại',

        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new MenuPosition();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();

        return redirect()->route('menuposition.edit', $model->id )->with('success', 'Tạo menu thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = MenuPosition::query()->find($id);
        return view('admin.menu-position.edit', compact('menu'));
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
            'title' => "required",
            'position' => "required|unique:menu_positions,position,$id",

        ],[
            'title.required' => 'Tiêu đề không được bỏ trống',
            'position.required' => 'Vị trí không được bỏ trống',
            'position.unique' => 'Vị trí đã tồn tại',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = MenuPosition::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();


        return redirect()->route('menuposition.edit', $model->id )->with('success', 'Cập nhật menu thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $menu = MenuPosition::query()->find($id);
                if ($menu->delete() && Menu::query()->where('menu_position_id', $id)->delete()) {
                    return response()->json([
                        'type' => 'success',
                        'code' => 200,
                        'message' => 'Xóa bản ghi thành công'
                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

    }

    public function MenuEdit ($id){
        $menu = MenuPosition::query()->find($id);
        $nestable = Menu::query()
            ->where([
                'parent_id' => 0,
                'menu_position_id' => $id
            ])->with('subMenu')->get();
        $listMenu = [
            'category' => ['title' => 'Danh mục'],
            'page' => ['title' => 'Trang'],
            'tag' => ['title' => 'Thẻ tag'],
            'post' => ['title' => 'Bài viết'],
            'product' => ['title' => 'Sản phẩm'],
            'product_category' => ['title' => 'Danh mục sản phẩm'],
        ];

        $listMenu['category']['list'] = Category::query()->whereNull('parent_id')->where('status', 1)->orderBy('id', 'desc')->get();
        $listMenu['product_category']['list'] = ProductCategory::query()->whereNull('parent_id')->where('status', 1)->orderBy('id', 'desc')->get();

        $listMenu['product']['list'] = Product::query()->where('status', 1)->get();
        $listMenu['page']['list'] = Page::query()->where('status', 1)->get();
        $listMenu['tag']['list'] = Tag::query()->where('status', 1)->get();
        $listMenu['post']['list'] = Post::query()->where('status', 1)->get();
        return view('admin.menu-position.menu',[
            'menu' => $menu,
            'list_menu' => $listMenu,
            'nestable' => $nestable
        ]);
    }

    public function MenuUpdate (Request $request, $id){
        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $menuData = $request->input('menu');
                Menu::query()->where('menu_position_id', $id)->delete();
                $topMenuOrder = 1;
                if (!empty($menuData)) {

                    foreach ($menuData as $key => $item) {
                        $menu = new Menu();
                        $tmp['title'] = $item['title'];
                        $tmp['guid'] = $item['guid'];
                        $tmp['slug'] = $item['slug'];
                        $tmp['type'] = $item['type'];
                        $tmp['menu_position_id'] = $id;
                        $tmp['sort'] = $topMenuOrder;
                        $tmp['parent_id'] = 0;
                        $menu->fill($tmp);
                        $menu->save();
                        if (!empty($item['children'])) {
                            $this->childSubMenus($menu->id, $item['children'], $request->input('menu_position_id'));
                        }
                        $topMenuOrder++;
                    }
                }
                return response()->json([
                    'type' => 'success',
                    'code' => 200,
                    'message' => 'Cập nhật menu thành công'
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'type' => 'error',
                'code' => 400,
                'message' => 'Bạn không được thực hiện thao tác này'
            ]);
        }


    }

    private function childSubMenus($menuID, $e, $menu_position_id)
    {
        $topMenuOrder = 1;
        foreach ($e as $key => $block) {
            $menu = new Menu();
            $tmp['title'] = trim($block['title']);
            $tmp['guid'] = trim($block['guid']);
            $tmp['slug'] = trim($block['slug']);
            $tmp['type'] = $block['type'];
            $tmp['menu_position_id'] = $menu_position_id;
            $tmp['sort'] = $topMenuOrder;
            $tmp['parent_id'] = $menuID;
            $menu->fill($tmp);
            $menu->save();
            if (!empty($block['children'])) {
                $this->childSubMenus($menu->id, $block['children'], $menu_position_id);
            }
            $topMenuOrder++;
        }
    }
}

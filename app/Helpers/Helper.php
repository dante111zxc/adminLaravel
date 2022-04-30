<?php

use App\Models\Menu;
use App\Models\MenuPosition;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

if (!function_exists('getThumbnail')) {
    function getThumbnail ($str){
        if (!empty($str)) {
            $file = public_path('media/'. $str);
            if (file_exists($file)) {
                return asset('media/' . $str);

            }
        }
        return asset('adminLTE/dist/img/no-img.png');
    }
}

if (!function_exists('getMenu')) {
    function getMenu ($menuPosition) {
        $menu_position = MenuPosition::query()->where('position', $menuPosition)->first();
        if (!empty($menuPosition)) {
            $menu = Menu::query()
                ->where([
                    'parent_id' => 0,
                    'menu_position_id' => $menu_position->id
                ])->with('recursiveMenu')->get();
        }

        return $menu;
    }
}

if ( !function_exists('getMenuItemUrl') ) {
    function getMenuItemUrl ($menuItem){
        return route($menuItem->type, ['slug' => $menuItem->slug, 'id' => $menuItem->guid]);
    }
}

if ( !function_exists('showMoney')) {
    function showMoney ($number){
        $number = str_replace('.', '', $number);
        $number = str_replace(',', '', $number);
        return number_format((int) $number, 0, '', '.') . '<sup>đ</sup>';
    }
}

if (!function_exists('getCartTotal')) {
    function getCartTotal ($string){
        $string = str_replace('.', '', $string);
        $string = str_replace(',', '', $string);
        return (int) $string;
    }
}

if (!function_exists('showCoin')) {
    function showCoin ($number){
        $number = str_replace('.', '', $number);
        $number = str_replace(',', '', $number);
        return number_format((int) $number, 0, '', '.') . ' Pcoin';
    }
}

if (!function_exists('saleOff')) {
    function saleOff ($item) {
        if (!empty($item->price_sale) && $item->price_sale < $item->price) {
            return '<span class="sale-off">-'.round(100 - (($item->price_sale * 100) / $item->price)).'%</span>';
        }
        return '';
    }
}

if (!function_exists('storeImage')) {
    function storeImage ($request){
        $validation = Validator::make($request->all(), [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $user = Auth::user();
        if (!$validation->fails()) {
            $image = $request->file('thumbnail');
            $new_name = rand() . '.' . Str::slug($image->getClientOriginalExtension());

            //check thư mục ảnh có tồn tại hay k
            $path = public_path('user/'.$user->id . '/');
            if (!file_exists($path)) {
                File::makeDirectory($path, '777');
            }
            $image->move(public_path('user/'.$user->id .'/'), $new_name);

            return [
                'message' => 'Gửi request thành công',
                'type' => 'success',
                'code' => 200,
                'data' => asset('user/' . $user->id . '/' .$new_name)
            ];
        } else {
            return [
                'message' => 'Gửi Request thất bại',
                'type' => 'error',
                'code' => 400
            ];
        }
    }
}

if (!function_exists('showName')) {
    function showName ($string){
        $strArr = explode(' ', $string);
        if (count($strArr)  >= 2) {
            return $strArr[count($strArr) - 2] .' '.$strArr[count($strArr) - 1];
        } else {
            return $string;
        }


    }
}

if (!function_exists('getContent')) {
    function getContent ($content){
        if (preg_match_all('#<img[^>]*src[^>]*>#Usmi', $content, $matches)) {
            foreach ($matches[0] as $tag) {
                if (preg_match_all('#src=(?:"|\')(?!data)(.*)(?:"|\')#Usmi', $tag, $urls, PREG_SET_ORDER)) {
                    foreach ($urls as $url) {
                        $full_src_orig = $url[0];
                        $url           = $url[1];
                        $lazy = 'src="' . $url . '"';
                        $lazy .= ' class="lazy"';
                        $lazy .= ' loading="lazy"';
                        $img_lazy = str_replace($full_src_orig, $lazy, $tag);
                        $content = str_replace($tag, $img_lazy, $content);
                    }
                };
            }
        }

        return $content;
    }
}

if (!function_exists('showRankImg')) {
    function showRankImg($totalAmount){
        if ($totalAmount >= 1000000 && $totalAmount < 5000000) {
            return '<img class="vip-member-img" src="'.asset('assets/img/icon/bac.png').'">';
        } else if ($totalAmount >= 5000000 && $totalAmount < 25000000) {
            return '<img class="vip-member-img" src="'.asset('assets/img/icon/vang.png').'">';
        } else if ($totalAmount >= 25000000 && $totalAmount < 50000000) {
            return '<img class="vip-member-img" src="'.asset('assets/img/icon/bachkim.png').'">';
        } else if ($totalAmount >= 50000000) {
            return '<img class="vip-member-img" src="'.asset('assets/img/icon/kimcuong.png').'">';
        }
    }
}

//kiem tra tong gia tri don hang cua 1 user
if (!function_exists('getTotalOrderAmountByUserId')) {
    function getTotalOrderAmountByUserId ($userId){
        return \App\Models\Orders::getTotalOrderAmountByUserId($userId);
    }
}

//tinh tong so phan tram giam gia vip member
if (!function_exists('getSalePercentByUserId')) {
    function getSalePercentByUserId($userId){
        $totalAmount = getTotalOrderAmountByUserId($userId);
        if ($totalAmount >= 1000000 && $totalAmount < 5000000) {
            return '1%';
        } elseif ($totalAmount >= 5000000 && $totalAmount < 25000000) {
            return '1%';
        } elseif ($totalAmount >= 25000000 && $totalAmount < 50000000){
            return '1.5%';
        } elseif ($totalAmount >= 50000000) {
            return '2%';
        } else {
            return '0%';
        }
    }
}

//tinh tong tien cua gio hang khi co vip memeber
if (!function_exists('getTotalCartWithSale')) {
    function getTotalCartWithSale($userId){
        $totalAmount = getTotalOrderAmountByUserId($userId);
        $total =  getCartTotal(Cart::total());
        $cashBack = 0;
        if ($total) {
            if ($totalAmount >= 1000000 && $totalAmount < 5000000) {
                $cashBack = (1 * $total) / 100;
            } elseif ($totalAmount >= 5000000 && $totalAmount < 25000000) {
                $cashBack = (1 * $total) / 100;
            } elseif ($totalAmount >= 25000000 && $totalAmount < 50000000){
                $cashBack = (1.5 * $total) / 100;
            } elseif ($totalAmount >= 50000000) {
                $cashBack = (2 * $total) / 100;
            }
            $totalCart = $total - $cashBack;
            return $totalCart;
        }

        return 0;
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat ($value, $decimals, $decimalPoint, $thousandSeperator){
        return number_format($value, $decimals, $decimalPoint, $thousandSeperator);
    }
}

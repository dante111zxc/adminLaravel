<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Mail\Order;
use App\Models\MethodPayments;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
class OrderController extends Controller
{

    public function addToCart (Request $request) {
       try {
           if ($request->ajax() && $request->isMethod('post')) {
               $id = $request->input('id');
               $quantity = $request->input('quantity');
               $product = Product::query()->find($id);
               if (!empty($product->stock)) {
                   $price = $product->price;
                   if (!empty($product->price_sale) && ($product->price_sale < $product->price)) {
                       $price = $product->price_sale;
                   }

                   $cart = Cart::add($product->id, $product->title, $quantity, $price);
                   $cart->associate(Product::class);
                   Artisan::call('cache:clear');
                   Artisan::call('view:clear');
                   $html = view('public.ajax.cart')->render();

                   return response()->json([
                       'type' => 'success',
                       'message' => "Thêm sản phẩm $product->title vào giỏ hàng thành công",
                       'code' => 200,
                       'html' => $html
                   ]);
               }

               else {
                   return response()->json([
                       'type' => 'error',
                       'message' => 'Sản phẩm này đã hết hàng',
                       'code' => 400
                   ]);
               }
           }
       } catch (Exception $exception) {
           return response()->json([
               'type' => 'error',
               'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
               'code' => 400
           ]);
       }

    }
    public function deleteItemFromCart (Request $request) {
       if ($request->ajax() && $request->isMethod('delete')) {
           $rowId = $request->input('rowId');
           try {
               $cart = Cart::remove($rowId);
               $data['cart'] = $cart;
               $data['cart_total'] = Cart::subtotal();
               Artisan::call('cache:clear');
               Artisan::call('view:clear');
               return response()->json([
                   'type' => 'success',
                   'message' => "Xóa sản phẩm thành công",
                   'data' => $data,
                   'code' => 200,
               ]);
           } catch (Exception $exception) {
               return response()->json([
                   'type' => 'error',
                   'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
                   'code' => 400
               ]);
           }
       }
    }
    public function updateQty (Request $request){
       if ($request->ajax() && $request->isMethod('post')) {
            $id = $request->input('id');
            $qty = $request->input('qty');
            $cart_content = Cart::content();
            foreach ($cart_content as $key => $item) {
                if ($item->id == $id) {
                    $rowId = $key;
                    break;
                }
            }

            if (!empty($rowId)) {
                Cart::update($rowId, $qty);
                return response()->json([
                    'type' => 'success',
                    'code' => 200,
                    'message' => 'Cập nhật giỏ hàng thành công',
                    'cart_total' => Cart::subtotal(),
                    'cart_count' => Cart::count()
                ]);
            }

           return response()->json([
               'type' => 'error',
               'code' => 400,
               'message' => 'Có lỗi xảy ra',
           ]);
       }
    }
    public function showCart () {
        if (!$cartTotal = numberFormat( getTotalCartWithSale(Auth::user()->id),0, ',', '.')) {
           $cartTotal = Cart::total();
        }
        return view('public.cart.index', compact('cartTotal'));
    }
    public function checkOut (){
        $methodPayments = MethodPayments::query()->where([
           'status' => 1
        ])->get();
        if (!$cartTotal = numberFormat( getTotalCartWithSale(Auth::user()->id),0, ',', '.')) {
           $cartTotal = Cart::total();
        }

        if (!Cart::count()) return redirect()->route('home');
        return view('public.cart.checkout', compact('methodPayments', 'cartTotal'));
    }
    public function quickBuy ($id){
       $product = Product::query()->find($id);
       if (!empty($product->stock)) {
           $price = $product->price;
           if (!empty($product->price_sale) && ($product->price_sale < $product->price)) {
               $price = $product->price_sale;
           }

           $cart = Cart::add($product->id, $product->title, 1, $price);
           $cart->associate(Product::class);
           Artisan::call('cache:clear');
           Artisan::call('view:clear');
           return redirect()->route('check_out');
       } else {
           return redirect()->back();
       }
    }
    public function orderDetail ($id){
       $order = Orders::query()->findOrFail($id);
       if (Auth::user()->id !== $order->user_id) {
           return redirect()->route('home');
       } else {
           $orderStatus = Orders::STATUS[$order->status];
           $methodPayment = Orders::METHODS_PAYMENT[$order->method_payment];
           $cart = Orders::orderDetail($order->id);
           return view('public.cart.order-detail', compact('order', 'orderStatus', 'methodPayment', 'cart'));
       }
    }
    public function submitCheckout (Request $request){
       try {
           $validator = Validator::make($request->all(), [
               'name' => 'required',
               'phone' => 'required',
               'address' => 'required',
               'email' => 'required|email',
               'method_payment' => 'required',
               'cart_total' => 'required'
           ],[
               'name.required' => 'Tên không được bỏ trống',
               'phone.required' => 'Số điện thoại không được bỏ trống',
               'address.required' => 'Địa chỉ không được bỏ trống',
               'email.required' => 'Email không được bỏ trống',
               'method_payment.required' => 'Chưa chọn phương thức thanh toán'
           ]);
           $cartTotal = $request->input('cart_total');
           if ($validator->fails()) {
               return redirect()->back()->withErrors($validator)->withInput();
           }

           //check xem co phai vip member k
           $isVipMember = 0;
           $vipMember = str_replace('%', '', getSalePercentByUserId(Auth::user()->id));
           if ($vipMember != 0) {
               $isVipMember = 1;
           }

//           if ($request->input('method_payment') != 2) {
//               return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'])->withInput();
//           }

           //check giá trị đơn hàng phải lớn hơn 0 mới cho đặt hàng
           if (!$cartTotal) return redirect()->back()->withErrors(['message' => 'Giá trị đơn hàng phải lớn hơn 0'])->withInput();

           //thanh toan bang pcoin
           if (Auth::user()->pcoin >= $cartTotal) {
               $pcoin = Auth::user()->pcoin - $cartTotal;
               $this->updatePcoin(Auth::user()->id, $pcoin);
           } else {
               return redirect()->back()->withErrors(['messages' => 'Số Pcoin không đủ'])->withInput();
           }



           $acc_info = array_filter(array_map('array_filter', $request->input('acc_info')));
           $order = Orders::query()->create([
               'name' => $request->input('name'),
               'phone' => $request->input('phone'),
               'address' => $request->input('address'),
               'email' => $request->input('email'),
               'link_facebook' => $request->input('link_facebook'),
               'user_id' =>  Auth::user()->id,
               'acc_info' => json_encode($acc_info),
               'method_payment' => $request->input('method_payment'),
               'subtotal' => getCartTotal(Cart::subtotal()),
               'total' =>$cartTotal,
               'status' => 0,
               'is_vip_member' => $isVipMember
           ]);


           $index = 0;
           foreach (Cart::content() as $key => $item) {
               $orderDetail[$index]['order_id'] = $order->id;
               $orderDetail[$index]['product_id'] = $item->id;
               $orderDetail[$index]['name'] = $item->name;
               $orderDetail[$index]['qty'] = (int) $item->qty;
               $orderDetail[$index]['price'] = (int) $item->price;
               $index++;
           }
           if (!empty($orderDetail)) {
               $insertOrderDetail = DB::table('order_detail')->insert($orderDetail);
               if (!empty($insertOrderDetail)) {
                   Mail::to($request->input('email'))->cc(env('MAIL_ADMIN'))
                       ->send(new Order($order, Cart::content(), $cartTotal));
               }
           }

           $cart = Cart::content();
           $orderStatus = Orders::STATUS[$order->status];
           $methodPayment = Orders::METHODS_PAYMENT[$order->method_payment];
           return view('public.cart.checkout-success', compact('order', 'cart', 'orderStatus', 'methodPayment', 'cartTotal'));
       } catch (\Exception $exception) {
           return redirect()->back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
       }
    }
    protected function updatePcoin ($userId, $pcoin){
        $user = User::query()->find($userId);
        return $user->fill([
            'pcoin' => $pcoin
        ])->save();
    }

}

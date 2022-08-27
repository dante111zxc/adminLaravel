@if (Cart::content()->count())
    <div class="cart-list-item-wrapper">
        @foreach(Cart::content() as $item)
            <div class="cart-item" data-row-id="{{ $item->rowId }}">
                <a class="thumbnail" href="{{ route('product', ['id' => $item->model->id, 'slug' => $item->model->slug]) }}">
                    <img src="{{ getThumbnail($item->model->thumbnail) }}" alt="{{ $item->model->title }}">
                </a>
                <div class="meta">
                    <div class="title">
                        <a href="{{ route('product', ['id' => $item->model->id, 'slug' => $item->model->slug]) }}">
                            {{ $item->model->title }}
                        </a>
                    </div>
                    <div class="price">{!! showMoney($item->price) !!}</div>
                    <div class="quantity">
                        <span class="minus" onclick="minusQty(this, '.quantity', true)" data-href="{{ route('update_qty') }}" data-id="{{ $item->model->id }}">-</span>
                        <input class="quantity-input" type="text" readonly value="{{ $item->qty }}">
                        <span class="plus" onclick="plusQty( this, '.quantity', true)" data-href="{{ route('update_qty') }}" data-id="{{ $item->model->id }}">+</span>
                        <span class="delete" data-href="{{ route('ajax_delete_item_from_cart') }}" data-id="{{ $item->id }}">
                           <i class="bi bi-trash"></i>
                       </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="padding: 1rem; line-height: 1.5">Chưa có sản phẩm nào trong giỏ hàng</div>
@endif

<div class="cart-total {{(Cart::content()->count()) == 0 ? 'd-none' : ''}}">
    <div class="text">Tổng phụ</div>
    <div class="mini-cart-sub-total">{!!  showMoney(Cart::subtotal()) !!}</div>
</div>

@if(\Illuminate\Support\Facades\Auth::user())
<div class="cart-total {{(Cart::content()->count()) == 0 ? 'd-none' : ''}}">
    <div class="text">Giảm giá Vip Member</div>
    <div class="mini-cart-sale-percent">{{ getSalePercentByUserId(\Illuminate\Support\Facades\Auth::user()->id) }}</div>
</div>

<div class="cart-total {{(Cart::content()->count()) == 0 ? 'd-none' : ''}}">
    <div class="text">Tổng tiền</div>
    <div class="mini-cart-total">{!! showMoney(getTotalCartWithSale(\Illuminate\Support\Facades\Auth::user()->id)) !!}</div>
</div>
@endif
<div class="cart-button {{(Cart::content()->count()) == 0 ? 'd-none' : ''}}">
    <a class="go-to-cart" href="{{ route('show_cart') }}">Giỏ hàng</a>
    <a class="btn-checkout" href="{{ route('check_out') }}">Thanh toán</a>
</div>

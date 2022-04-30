@extends('public.layouts.app')

@section('content')
    <div class="container">

    @if($breadcrumb)
        <!-- start breadcrumb -->
            <div class="row">
                <div class="bread-crumbs-hr col-12">
                    @foreach($breadcrumb as $item)
                        <div class="bread-crumbs-hr__item fRbizP">
                            <a href="{{ $item['url'] }}" class="bread-crumbs-hr__link">{{ $item['title'] }}</a><span
                                    class="bread-crumbs-hr__spliter">&gt;</span>
                        </div>
                    @endforeach
                </div>
                <h1 class="buy_title col-12">{{ $product->title }}</h1>
            </div>
            <!-- end breadcrumb -->
    @endif


        @php
            $gallery = json_decode($product->gallery);
        @endphp
        <!-- start slider -->
        <div class="row">
            <div class="col-12 col-md-8">
                @if ( !empty($gallery) )
                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper-container product-detail-slide product-detail-swiper">
                    <div class="swiper-wrapper">
                        @foreach( $gallery as $item)
                        <div class="swiper-slide">
                            <img src="{{ getThumbnail($item) }}" alt="{{ $product->title }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-container product-detail-slide product-detail-small-swiper">
                    <div class="swiper-wrapper">
                        @foreach( $gallery as $item)
                        <div class="swiper-slide">
                            <img src="{{ getThumbnail($item) }}" alt="{{ $product->title }}">
                        </div>
                        @endforeach
                    </div>
                    <div class="navigation-button swiper-button-next1">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                    <div class="navigation-button swiper-button-prev1">
                        <i class="bi bi-chevron-left"></i>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 col-md-4">
                <div class="card-buy-wrapper">
                    <div class="card-buy">
                        <div class="card-buy__head">
                            <p>
                                <span class="card-buy__acti__icon">
                                    @if($product->stock === 0)
                                        <i class="bi bi-x-circle text-danger"></i>
                                        @else
                                        <i class="bi bi-check-circle text-success"></i>
                                    @endif

                                </span>
                                <span class="card-buy__acti__in">Trạng thái:
                                    <strong>
                                        {{ ($product->stock == 0) ? 'Hết hàng' : 'Còn hàng' }}
                                    </strong>
                                </span>
                            </p>


                            <p>
                                <span class="card-buy__acti__icon"><i class="bi bi-upc"></i></span>
                                <span class="card-buy__acti__in">Mã sản phẩm: <strong>{{ $product->sku }}</strong></span>
                            </p>
                        </div>


                        <div class="card-buy__body">
                            <div class="card-buy__body__price">
                               @if ( !empty($product->price) && !empty($product->price_sale) && ( $product->price >  $product->price_sale) )
                                    <div class="low-price">
                                        <del><strong>{!! showMoney($product->price) !!}</strong></del>
                                    </div>
                               @endif
                                <div class="primary-price" onclick="data()">
                                    <span>
                                        @if ( !empty( $product->price_sale)  && $product->price_sale < $product->price )
                                            {!! showMoney($product->price_sale) !!}
                                        @else
                                            {!! showMoney($product->price) !!}
                                        @endif
                                    </span>
                                    @if (!empty($saleOff))
                                    <span class="sale-off">-{{ $saleOff }}%</span>
                                    @endif
                                </div>

                            </div>

                            <div class="card-buy__body__price">
                                @if($countVote)
                                    <div class="text-center">
                                        <div class="rateit" data-rateit-value="{{ $average }}" data-rateit-ispreset="true" data-rateit-readonly="true" data-rateit-mode="font" ></div>
                                    </div>
                                    <div class="percent text-center">
                                        <strong>{{ $average }}</strong>
                                        <span>/</span>
                                        <strong>5</strong>
                                        <span>Đánh giá của khách hàng</span>
                                    </div>
                                    @else
                                    <div class="percent text-center">
                                        <strong>Sản phẩm chưa có đánh giá</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="card-buy__body__price">

                                @if (!empty($productBundle))
                                <div class="select-attributes mb-3">
                                    <h4>Chọn gói sản phẩm: </h4>
                                    @foreach($productBundle as $item)
                                        <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}" class="btn btn-sm">{{ $item->title }}</a>
                                    @endforeach
                                </div>
                                @endif
                                <div class="select-quantity">
                                    <h4 class="mb-0 mr-4">Số lượng: </h4>
                                    <span class="minus" onclick="minusQty(this,'.select-quantity', false)">-</span>
                                    <input class="quantity-input" type="text" value="1" required
                                           placeholder="Nhập số lượng">
                                    <span class="plus" onclick="plusQty(this,'.select-quantity', false)">+</span>
                                </div>
                            </div>

                            <div class="card-buy__footer d-flex  no-gutters">
                                <div class="col pr-1">
                                    <button class="btn-buy-now {{ ($product->stock == 0) ? 'disable' : '' }}" data-href="{{ route('ajax_add_to_cart') }}" data-id="{{ $product->id }}"><i class="bi bi-bag-plus"></i> Thêm vào giỏ</button>
                                </div>

                                <div class="col pl-1">
                                    <a href="{{ route('check_out') }}" target="_blank" class="btn btn-quick-buy"><i class="bi bi-arrow-right"></i> Đến giỏ hàng</a>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>



            @if (!empty($product->short_desc))
            <div class="col-12">
                <div class="short-desc">
                    <h3>Lưu ý khi mua hàng</h3>
                    <div class="short-desc-content">
                        {{ $product->short_desc }}
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- end slider -->

        <!-- start-product-info -->
        <div class="product-info">
            <div class="container">
                <div class="row">
                    <div id="tabs-product-detail" class="col-12">
                        <ul class="nav nav-tabs list-info-link">
                            <li class="active">
                                <a data-toggle="tab" class="info-link" href="#tabs-1">Thông tin sản phẩm</a>
                            </li>

                            <li><a data-toggle="tab" class="info-link" href="#tabs-2">Chính sách bảo hành</a></li>

                        </ul>
                        <div class="tab-content">
                            <div id="tabs-1" class="info-para tab-pane fade in active show">
                                <div class="product-content">
                                    {!! getContent($product->content) !!}
                                </div>

                            </div>

                            <div id="tabs-2" class="info-para tab-pane fade">
                                @if(!empty($setting))
                                    {!! $setting->value !!}
                                    @else
                                    {{ 'Đang cập nhật' }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end-product-info -->

    </div>

    <!-- start-goto-product -->
    <div class="product-rating">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-review">
                        <h4>Bình luận</h4>
                        @if(Auth::check())

                        <div class="user-review">
                            <a class="avatar" href="{{ route('profile')}}">
                                <img class="rounded-circle" src="{{ asset('assets/img/og_img.png') }}" alt="avatar">
                            </a>
                            <span class="name">{{ Auth::user()->name }}</span>
                        </div>

                        <div class="review">
                            <div class="desc">Đánh giá của bạn về sản phẩm này</div>
                            <div class="rate-review">
                                <input type="range" value="5" step="1" id="rate-input">
                                <div id="rate-star" class="rateit" data-rateit-backingfld="#rate-input" data-rateit-mode="font" data-rateit-resetable="false" data-rateit-min="0" data-rateit-max="5"></div>
                            </div>
                        </div>

                        <div class="review-form">
                            <form id="submit-review" data-href="{{ route('submit_review') }}" method="POST">
                                <input type="hidden" name="vote" class="vote-review" value="5">
                                <input type="hidden" name="user_id" class="user-id-review" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="post_id" class="post-id-review" value="{{ $product->id }}">
                                <input type="hidden" name="type" class="type-review" value="product">
                                <input type="hidden" name="slug" class="slug-review" value="{{ $product->slug }}">
                                <textarea name="content" class="form-control content-review" rows="5"></textarea>
                                <button type="submit" class="btn-add-review">Gửi đánh giá</button>
                            </form>
                        </div>
                            @else
                            <div class="review">
                                <div class="desc">Vui lòng <a style="color: #d25645;" href="{{ route('login') }}"><b>đăng nhập</b></a> để bình luận</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end-goto-product -->




    <!-- start comments -->

    <div class="comments-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if($reviews)
                        @foreach($reviews as $key => $review)
                            <div class="post-review-content">
                                <span class="profile-avatar">
                                    <img class="rounded-circle" src="{{ asset('assets/img/og_img.png') }}" alt="avatar">
                                </span>

                                <div class="post-container">
                                    <div class="post-detail">
                                        <div class="user-info">
                                            <h5>
                                                <a href="{{ route('profile') }}" class="profile-link">{{ $review->user->name }}</a>
                                            </h5>
                                            <span>đã đánh giá</span>
                                            <div class="rateit" data-rateit-value="{{ $review->vote }}" data-rateit-ispreset="true" data-rateit-readonly="true" data-rateit-mode="font" ></div>
                                            <p class="post-comment-content">{{ $review->content }}</p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach

                        {{ $reviews->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- end comments -->

@endsection

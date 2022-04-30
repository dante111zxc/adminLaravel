@extends('public.layouts.app')

@section('content')
{{--    @dd(\Illuminate\Support\Facades\Auth::guard())--}}
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            @php
                $menuSidebar = getMenu('menu-sidebar');
            @endphp
            @if($menuSidebar)
            <nav class="widget-menu">
                <h2 class="header"><i class="bi bi-list"></i><span>Danh mục sản phẩm</span></h2>
                <ul class="menu">
                    @foreach($menuSidebar as $item)
                    <li class="menu-item">
                        <a class="menu-link" href="{{ getMenuItemUrl($item) }}">{{ $item->title }} @if($item->recursiveMenu->count() > 0) <span class="drop-icon"><i class="bi bi-chevron-right"></i></span> @endif</a>
                        @if($item->recursiveMenu->count() > 0)
                            <ul class="sub-menu">
                                @foreach ($item->recursiveMenu as $subMenu)
                                    @include('public.partial.submenu', ['subMenu' => $subMenu])
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </nav>
            @endif
        </div>
        <div class="col-12 col-md-6 col-xl-9">
            <div class="row no-gutters">
                <div class="col-12 col-xl-9 px-2">
                    @if (!empty($slide))
                    <div class="home-carousel">
                        <!-- Additional required wrapper -->
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @foreach( $slide as $item )
                                <div class="swiper-slide">
                                    <a class="d-block" href="{{ ($item->url) ? $item->url : '#' }}">
                                        <img class="swiper-lazy" src="{{ asset('assets/img/lazy.png') }}" data-src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                                        <!-- Preloader image -->
                                        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>
                            <!-- If we need scrollbar -->
                            <div class="swiper-scrollbar"></div>
                        </div>



                        <!-- If we need navigation buttons -->
                        <i class="button-prev bi bi-chevron-left"></i>
                        <i class="button-next bi bi-chevron-right"></i>


                    </div>
                    @endif
                </div>
                <div class="col-12 col-xl-3 px-2">
                    @if(!empty($banner))
                        @foreach( $banner as $key => $item)
                            <a class="banner-feature" href="{{ $item->url }}">
                                <img loading="lazy" src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                            </a>
                            @if($key == 2) @break @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="row no-gutters">

            @if(!empty($banner))
                @foreach( $banner as $key => $item)
                    @if($key > 2)
                        <div class="col-12 col-md-6 col-xl-4 px-2 mt-2 {{ ($key === 2 ) ? "d-md-none d-xl-block" : '' }}">
                            <a class="banner-feature-bottom" href="{{ $item->url }}">
                                <img loading="lazy" src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                            </a>
                        </div>
                    @endif
                    @if($key > 4) @break @endif
                @endforeach
            @endif

            </div>
        </div>

        @if(!empty($productFeature))

        <div class="col-12">
            <div class="section">
                <h2 class="section-title">Sản phẩm nổi bật</h2>
                <div class="product-list">
                    @foreach($productFeature as $item)
                        <div data-wow-duration="1.5s" class="card col-1/2 col-md-1/5 border-0 wow fadeIn">
                            {!! saleOff($item) !!}
                            <a class="d-block" href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                <img loading="lazy" src="{{ getThumbnail($item->thumbnail) }}" class="card-img-top">
                            </a>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}" title="{{ $item->title }}">
                                        {{ $item->title }}
                                    </a>
                                </h5>
                            </div>
                            <div class="price">
                                @if ( !empty($item->price) && !empty($item->price_sale) && ( $item->price >  $item->price_sale) )
                                <span class="regular-price"><del>{!! showMoney($item->price) !!}</del></span>
                                @endif

                                @if( !empty($item->price_sale) && ($item->price_sale < $item->price))
                                <span class="price-sale">{!! showMoney($item->price_sale) !!}</span>
                                    @else
                                <span class="price-sale">{!! showMoney($item->price) !!}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($productCategoryFeature)
        <div class="col-12">
            <div class="section">
                <div class="section-title">Danh mục nổi bật</div>
            </div>
        </div>

        @foreach($productCategoryFeature as $itemProductCat)
            <div class="col-12 col-md-3 col-lg-3">
                <div class="category-item">
                    <a class="thumbnail" href="{{ route('product_category', ['id' => $itemProductCat->id, 'slug' => $itemProductCat->slug]) }}">
                        <img src="{{ getThumbnail($itemProductCat->thumbnail) }}" alt="{{ $itemProductCat->title }}">
                    </a>
                    <a class="title" href="{{ route('product_category', ['id' => $itemProductCat->id, 'slug' => $itemProductCat->slug]) }}">
                        {{ $itemProductCat->title }}
                    </a>
                </div>
            </div>
        @endforeach

        @endif


        @if($lastedPost)
        <div class="col-12">
            <div class="section mb-5">
                <h2 class="section-title">Tin Game</h2>
                <div class="row">
                    @foreach($lastedPost as $item)
                    <div class="col-12 col-md-4">
                        <div class="post-item">
                            <a class="title" href="{{ route('post', ['slug' => $item->slug, 'id' => $item->id]) }}">
                                <img loading="lazy" src="{{ getThumbnail($item->thumbnail)  }}" alt="{{ $item->slug }}">
                                <span>{{ $item->title }}</span>
                            </a>
                            @if($item->category->count() > 0)
                                @php
                                    $oneCategory = $item->category->toArray();
                                    $oneCategory = array_shift($oneCategory);

                                @endphp
                                <a class="category" href="{{ route('category', ['id' => $oneCategory['id'], 'slug' => $oneCategory['slug']]) }}" title=" {{ $oneCategory['title'] }}">
                                    {{ $oneCategory['title'] }}
                                </a>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('public.layouts.app')

@section('content')
    <div class="container-xl">

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
            <h1 class="buy_title col-12">{{ $post->title }}</h1>
        </div>
        <!-- end breadcrumb -->

        @endif
    </div>

    <div class="wrapper-main-detail">
        <div class="container-xl">
            <!-- start main detail -->
            <div class="row">
                <div class="col-12 col-10">
                    <div class="main-thumbnail">
                        <img loading="lazy" src="{{ getThumbnail($post->thumbnail) }}" alt="{{ $post->title }}">
                    </div>
                    <div class="mail-desc">
                        {{ $post->desc }}
                    </div>
                    <div class="main-content">
                        {!! getContent($post->content) !!}
                    </div>
                </div>
            </div>
            <!-- end main detail -->
        </div>
    </div>
    <!-- start other-detail-page -->
    <div class="wrapper-meta">
        <div class="container-xl">
            <div class="container">
                <div class="single-post-meta">
                    <div class="tagcloud">
                        @if($post->tag) @foreach($post->tag as $item)
                            <a href=" {{ route('tag', ['id' => $item->id, 'slug' => $item->slug]) }}" class="tag-cloud-link">{{ $item->title }}</a>
                        @endforeach @endif
                    </div>
                    <div class="social-icon">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end other-detail-page -->


    @if ($postRelated)
    <!-- start other-detail-page -->
    <div class="wrapper-other-detail-page">
        <div class="container-xl">
            <div class="container">
                <div class="row">
                    @foreach ($postRelated as $item)
                    <div class="other-detail-page col-12 col-md-6">
                        <img src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}" class="other-detail-page__img">
                        <h3 class="other-detail-page__title">
                            <a href="{{ route('post', ['id' => $item->id, 'slug' => $item->slug]) }}">{{ $item->title }}</a>
                        </h3>
                        <p class="other-detail-page__para">
                            {{ $item->desc }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- end other-detail-page -->
    @endif



    <!-- start author info -->
{{--    <div class="wrapper-author-info">--}}
{{--        <div class="container-xl">--}}
{{--            <div class="container">--}}
{{--                <div class="author-info">--}}
{{--                    <div class="avatar">--}}
{{--                        <img src="{{ asset('assets/img/author.png') }}" alt="admin">--}}
{{--                    </div>--}}
{{--                    <div class="description">--}}
{{--                        <h5 class="author-title"> <a href="#">Admin - Polly Keller</a></h5>--}}
{{--                        <span class="author-meta">Professional athlete</span>--}}
{{--                        <div class="author-description">--}}
{{--                            When I stand before God at the end of my life, I would hope that I would not have a single bit of talent--}}
{{--                            left and could say, I used everything you gave me.--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- end author info -->

@endsection

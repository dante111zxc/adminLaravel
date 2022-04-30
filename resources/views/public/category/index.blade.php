@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-category-content">
                    <h1>{{ $category->title }}</h1>
                    <div class="desc">
                        {{ $category->desc }}
                    </div>
                </div>
            </div>

            @if($posts)
                @foreach($posts as $item)
                    <div class="col-12 col-md-4 col-xl-4">
                        <div class="post-item">
                            <a class="title" href="{{ route('post', ['id' => $item->id, 'slug' => $item->slug]) }}" title="{{ $item->title }}">
                                <img src="{{ getThumbnail($item->thumbnail) }}">
                                <span>{{ $item->title }}</span>
                            </a>
                            <div class="post-excerpt">
                                {{ $item->desc }}
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="col-12 mt-5">
                        {{ $posts->links() }}
                    </div>
            @endif

        </div>
    </div>
@endsection

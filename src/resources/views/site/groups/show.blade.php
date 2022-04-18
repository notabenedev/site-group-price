@extends('layouts.boot')

@section('page-title', $group->title.' - '.config("site-group-price.sitePackageName","Прайс "))

@section('content')
    @if (! config("site-group-price.onePage",false))
        <div class="col-12 col-lg-4 order-lg-first">
            @include('site-group-price::site.groups.includes.sidebar', ["group" => $group])
        </div>
    @endif

    <div class="col-12 col-lg-8">
        <div class="row price__group">
            <div class="col-12">
                <h1 class="h1">
                    {{  $group->title }}
                </h1>
                @isset($group->short)
                    <div class="price__group-short">
                        {!! $group->short  !!}
                    </div>
                @endisset
            </div>
        </div>

        @if (config("site-group-price.siteHeadersShow", true) && $group->prices->count())
            <div class="row price__header">
                <div class="col-12 col-sm-7 col-md-8 col-lg-9 price__header-title">
                    {{ config("site-group-price.sitePriceHeaderTitleName", 'Наименование') }}
                </div>
                <div class="col-12 col-sm-5 col-md-4 col-lg-3 price__header-price">
                    {{ config("site-group-price.sitePriceHeaderPriceName", 'Цена (в рублях)') }}
                </div>
            </div>
        @endif

{{--        @foreach(\Notabenedev\SiteGroupPrice\Facades\PriceActions::getGroupPriceIds($group->id) as $id => $price)--}}
{{--            @include('site-group-price::site.groups.includes.item-price',--}}
{{--            ['id' => $id, 'loop' => $loop, 'price' => $price, 'margin' => true]--}}
{{--            )--}}
{{--        @endforeach--}}
        @foreach($group->prices as $price)
            @include('site-group-price::site.groups.includes.item-price',
            ['id' => $price->id, 'loop' => $loop, 'price' => $price, 'margin' => true]
            )
        @endforeach

        @if($group->nested)
            @foreach($groups as $item)
                <div class="row price__group">
                    @if (isset($item["published_at"]))
                        <div class="col-12">
                            @include("site-group-price::site.groups.includes.item", ["item" => $item, "first" => true, "level" => 1])
                        </div>
                    @endif
                </div>
            @endforeach
            @else
            <div class="row price__group">
                <div class="col-12 d-flex flex-column flex-sm-row">
                @foreach($group->children as $item)
                    @if (isset($item->published_at))
                        <a class="btn btn-outline-primary price__group-child" href="{{ route("site.groups.show", ["group" => $item]) }}">
                            {{ $item->title }}
                        </a>
                    @endif
                @endforeach
                </div>
            </div>
        @endif

        <div class="row price__group">
            <div class="col-12">
                @isset($group->description)
                    <div class="price__group-description">
                        {!! $group->description  !!}
                    </div>
                @endisset
                @isset($group->accent)
                    <div class="price__group-accent">
                        {{ $group->accent }}
                    </div>
                @endisset
                @isset($group->info)
                    <div class="price__group-info">
                        {!! $group->info !!}
                    </div>
                @endisset
            </div>
        </div>

    </div>

@endsection


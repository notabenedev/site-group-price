@extends('layouts.boot')

@section('page-title', config("site-group-price.sitePackageName","Прайс").' - ')

@section('header-title')
       {{ config("site-group-price.sitePackageName","Прайс ") }}
@endsection

@section('content')
    <div class="col-12">
        @if (config("site-group-price.siteHeadersShow", true))
            <div class="row price__header">
                <div class="col-12 col-sm-7 col-md-8 col-lg-9 price__header-title">
                    {{ config("site-group-price.sitePriceHeaderTitleName", 'Наименование') }}
                </div>
                <div class="col-12 col-sm-5 col-md-4 col-lg-3 price__header-price">
                    {{ config("site-group-price.sitePriceHeaderPriceName", 'Цена (в рублях)') }}
                </div>
            </div>
        @endif
        @foreach($groups as $item)
                <div class="row price__group">
                    <div class="col-12">
                    @include("site-group-price::site.groups.includes.item", ["item" => $item, "first" => true, "level" => 1])
                    </div>
                </div>
            @endforeach
    </div>
@endsection

@if (config("site-group-price.onePage",true))
@section("sidebar")
    <ul class="list-unstyled price__menu">
        @foreach($rootGroups as $key => $item)
            <li class="price__menu-item">
                <a class="price__menu-item_link" href="#{{ $item["slug"] }}">{{ $item["title"] }}</a>
            </li>
        @endforeach
    </ul>
@endsection
@endif
@extends('layouts.boot')

@section('page-title', config("site-group-price.sitePackageName","Прайс").' - ')

@section('header-title')
       {{ config("site-group-price.sitePackageName","Прайс ") }}
@endsection

@if (! config("site-group-price.onePage",false))
@section("sidebar")
    @include('site-group-price::site.groups.includes.sidebar')
@endsection
@endif

@section('content')
    <div class="col-12 col-lg-8">
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
    @if (config("site-group-price.onePage",true))
        <div class="col-12 col-lg-4">
        @include('site-group-price::site.groups.includes.sidebar-one-page')
        </div>
    @endif
@endsection


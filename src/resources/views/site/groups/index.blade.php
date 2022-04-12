@extends('layouts.boot')

@section('page-title', config("site-group-price.sitePackageName","Прайс").' - ')

@section('header-title')
       {{ config("site-group-price.sitePackageName","Прайс ") }}
@endsection

@section('content')
    <div class="col-12 col-lg-8">
        @if (config("site-group-price.siteHeadersShow", true))
            <div class="row price__header">
                <div class="col-12 col-sm-7 col-md-8 col-lg-9 ">
                    {{ config("site-group-price.siteHeadersTitle", 'Наименование') }}
                </div>
                <div class="col-12 col-sm-5 col-md-4 col-lg-3 text-sm-right">
                    {{ config("site-group-price.siteHeadersTitle", 'Цена (в рублях)') }}
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
    <div class="col-12 col-lg-4">

    </div>
@endsection

@if (config("site-group-price.onePage",true))
@section("sidebar")
    <ul class="list-unstyled price-menu">
        @foreach($rootGroups as $key => $item)
            <li class="price-menu__item">
                <a class="price-menu__item-link" href="#{{ $item["slug"] }}">{{ $item["title"] }}</a>
            </li>
        @endforeach
    </ul>
@endsection
@endif
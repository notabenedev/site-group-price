@extends("admin.layout")

@section("page-title", config("site-group-price.sitePricesName")." - ".config("site-group-price.sitePackageName")." - ")

@section('header-title')
    @empty($group)
        {{ config("site-group-price.sitePricesName") }}
    @else
       Приоритет позиций группы: {{ $group->title }}
    @endempty
@endsection
@section('admin')
    @isset($group)
        @include("site-group-price::admin.prices.includes.pills")
    @endisset
    <div class="col-12">
        <div class="card">
            <div class="card-body">
               <universal-priority
                       :elements="{{ json_encode($groups) }}"
                       url="{{ route("admin.vue.priority", ["table" => "prices", "field" => "priority"]) }}"
               >
               </universal-priority>
            </div>
        </div>
    </div>
@endsection
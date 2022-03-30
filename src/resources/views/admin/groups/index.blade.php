@extends("admin.layout")

@section("page-title", config("site-group-price.siteGroupsName")." - ".config("site-group-price.sitePackageName")." - ")

@section('header-title', config("site-group-price.siteGroupsName"))

@section('admin')
    @include("site-group-price::admin.groups.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($isTree)
                    @include("site-group-price::admin.groups.includes.tree", ["groups" => $groups])
                @else
                    @include("site-group-price::admin.groups.includes.table-list", ["groups" => $groups])
                @endif
            </div>
        </div>
    </div>
@endsection
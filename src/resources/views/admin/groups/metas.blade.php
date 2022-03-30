@extends("admin.layout")

@section("page-title", "{$group->title} - ")

@section('header-title', "{$group->title}")

@section('admin')
    @include("site-group-price::admin.groups.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Добавить тег</h5>
            </div>
            <div class="card-body">
                @include("seo-integration::admin.meta.create", ['model' => 'groups', 'id' => $group->id])
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                @include("seo-integration::admin.meta.table-models", ['metas' => $group->metas])
            </div>
        </div>
    </div>
@endsection
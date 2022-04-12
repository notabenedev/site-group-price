@extends("admin.layout")

@section("page-title", "{$group->title} - ")

@section('header-title', "{$group->title}")

@section('admin')
    @include("site-group-price::admin.groups.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    @if ($group->short)
                        <dt class="col-sm-3">Краткое описание</dt>
                        <dd class="col-sm-9">{{ $group->short }}</dd>
                    @endif
                    @if ($group->description)
                        <dt class="col-sm-3">Описание</dt>
                        <dd class="col-sm-9">{!! $group->description !!}</dd>
                    @endif
                    @if ($group->accent)
                        <dt class="col-sm-3">Акцент</dt>
                        <dd class="col-sm-9">{{ $group->accent}}</dd>
                    @endif
                    @if ($group->info)
                        <dt class="col-sm-3">Информация</dt>
                        <dd class="col-sm-9">{!! $group->info !!}</dd>
                    @endif
                        @if(! config("site-group-price.onePage", false))
                            @if ($group->nested)
                            <dt class="col-sm-3">Раскрыть все вложенные группы</dt>
                            <dd class="col-sm-9">Да</dd>
                            @endif
                    @endif
                    @if ($group->parent)
                        <dt class="col-sm-3">Родитель</dt>
                        <dd class="col-sm-9">
                            <a href="{{ route("admin.groups.show", ["group" => $group->parent]) }}">
                                {{ $group->parent->title }}
                            </a>
                        </dd>
                    @endif
                    @if ($childrenCount)
                        <dt class="col-sm-3">Дочерние</dt>
                        <dd class="col-sm-9">{{ $childrenCount }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
    @if ($childrenCount)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Подкатегории</h5>
                </div>
                <div class="card-body">
                    @include("site-group-price::admin.groups.includes.table-list", ["groups" => $children])
                </div>
            </div>
        </div>
    @endif
@endsection
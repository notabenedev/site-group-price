@extends("admin.layout")

@section("page-title", config("site-pages.sitePagesName")." - ".config("site-pages.sitePackageName")." - ")

@section('header-title')
    @empty($folder)
        {{ config("site-pages.sitePagesName") }}
    @else
        {{ $folder->title }} | Порядок
    @endempty
@endsection
@section('admin')
    @isset($folder)
        @include("site-pages::admin.pages.includes.pills")
    @endisset
    <div class="col-12">
        <div class="card">
            <div class="card-body">
               <universal-priority
                       :elements="{{ json_encode($groups) }}"
                       url="{{ route("admin.vue.priority", ["table" => "pages", "field" => "priority"]) }}"
               >

               </universal-priority>
            </div>
        </div>
    </div>
@endsection
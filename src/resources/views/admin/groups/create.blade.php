@extends("admin.layout")

@section("page-title", config("site-group-price.siteGroupsName")." - создать")

@section('header-title', config("site-group-price.siteGroupsName")." - создать")

@section('admin')
    @include("site-group-price::admin.groups.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @php($route = empty($group) ? route("admin.groups.store") : route("admin.groups.store-child", ["group" => $group]))
                <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               required
                               value="{{ old('title') }}"
                               class="form-control @error("title") is-invalid @enderror">
                        @error("title")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Адресная строка</label>
                        <input type="text"
                               id="slug"
                               name="slug"
                               value="{{ old('slug') }}"
                               class="form-control @error("slug") is-invalid @enderror">
                        @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="short">Краткое описание</label>
                        <input type="text"
                               id="short"
                               name="short"
                               value="{{ old('short') }}"
                               class="form-control @error("short") is-invalid @enderror">
                        @error("short")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea class="form-control tiny @error("description") is-invalid @enderror"
                                  name="description"
                                  id="description"
                                  rows="3">{{ old('description') }}</textarea>
                        @error("description")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="accent">Акцент</label>
                        <input type="text"
                               id="accent"
                               name="accent"
                               value="{{ old('accent') }}"
                               class="form-control @error("accent") is-invalid @enderror">
                        @error("accent")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="info">Информация</label>
                        <textarea class="form-control tiny @error("info") is-invalid @enderror"
                                  name="info"
                                  id="info"
                                  rows="3">{{ old('info') }}</textarea>
                        @error("info")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input"
                                       type="checkbox"
                                       {{ ( old("nested", "")) ? "checked" : "" }}
                                       value="true"
                                       id="nested"
                                       name="nested">
                            <label class="custom-control-label" for="nested">
                                   Раскрыть все вложенные группы
                            </label>
                        </div>
                    </div>

                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
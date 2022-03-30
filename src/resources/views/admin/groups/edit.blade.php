@extends("admin.layout")

@section("page-title", "{$group->title} - ")

@section('header-title', "{$group->title}")

@section('admin')
    @include("site-group-price::admin.groups.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.groups.update", ["group" => $group]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("put")

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               required
                               value="{{ old("title", $group->title) }}"
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
                               value="{{ old("slug", $group->slug) }}"
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
                               value="{{ old("short", $group->short) }}"
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
                                  rows="3">{{ old('description', $group->description) }}</textarea>
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
                               value="{{ old('accent', $group->accent) }}"
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
                                  rows="3">{{ old('info', $group->info) }}</textarea>
                        @error("info")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
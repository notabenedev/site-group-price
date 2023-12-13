@extends("admin.layout")

@section("page-title", "{$group->title} - Добавить позицию")

@section('header-title', "{$group->title} - Добавить позицию")

@section('admin')
    @include("site-group-price::admin.prices.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.groups.prices.store", ["group" => $group]) }}" method="post"  enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               maxlength="150"
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
                               maxlength="150"
                               value="{{ old('slug') }}"
                               class="form-control @error("slug") is-invalid @enderror">
                        @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Цена <span class="text-danger">*</span></label>
                        <input type="text"
                               id="price"
                               name="price"
                               maxlength="150"
                               required
                               value="{{ old('price') }}"
                               class="form-control @error("price") is-invalid @enderror">
                        @error("price")
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

                    @if (config("site-group-price.usePriceImage"))
                        <div class="form-group">
                            <label for="custom-file-input">Изображение</label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                       id="custom-file-input"
                                       lang="ru"
                                       name="image">
                                <label class="custom-file-label"
                                       for="custom-file-input">
                                    Выберите файл
                                </label>
                                @if ($errors->has('image'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
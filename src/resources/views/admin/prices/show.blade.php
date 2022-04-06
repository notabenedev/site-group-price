@extends("admin.layout")

@section("page-title", "{$price->title} - ")

@section('header-title', "{$price->title}")

@section('admin')
    @include("site-group-price::admin.prices.includes.pills")
    <div class="col-12">
        <div class="card">
            @can("update", $price)
                <div class="card-header">
                    <button type="button" class="btn btn-warning collapse show collapseChangeGroup" data-toggle="modal" data-target="#ChangeGroup">
                        Изменить группу
                    </button>
                    <div class="collapse mt-3 collapseChangeGroup">
                        <form class="form-inline"
                              method="post"
                              action="{{ route("admin.prices.change-group", ['price' => $price]) }}">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="group_id" class="sr-only">Группа </label>
                                <div class="input-group">
                                    <select name="group_id"
                                            id="group_id"
                                            class="custom-select">
                                        @foreach($groups as $key => $value)
                                            <option value="{{ $key }}"
                                                    @if ($key == $group->id)
                                                    selected
                                                    @elseif (old('group_id'))
                                                    selected
                                                    @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Обновить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
            <div class="card-body">
                <dl class="row">
                    @if ($price->slug)
                        <dt class="col-sm-3">Адресная строка:</dt>
                        <dd class="col-sm-9">
                            {{ $price->slug }}
                        </dd>
                    @endif
                    @if ($price->price)
                        <dt class="col-sm-3">Цена:</dt>
                        <dd class="col-sm-9">
                            {{ $price->price }}
                        </dd>
                    @endif
                    @if ($price->description)
                        <dt class="col-sm-3">Описание:</dt>
                        <dd class="col-sm-9">
                            <div>{!! $price->description !!}</div>
                        </dd>
                    @endif

                </dl>
            </div>
        </div>
    </div>

    @can("update", $price)
        <div class="modal fade" id="ChangeGroup" tabindex="-1" role="dialog" aria-labelledby="ChangeGroupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ChangeGroupLabel">Вы уверены?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button"
                                class="btn btn-primary"
                                data-dismiss="modal"
                                data-toggle="collapse"
                                data-target=".collapseChangeGroup"
                                aria-expanded="false"
                                aria-controls="collapseChangeGroup">
                            Понятно
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
@if (! empty($group))
    @include("site-group-price::admin.groups.includes.breadcrumb")
@endif
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\Group::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.groups.index") }}"
                           class="nav-link{{ isset($isTree) && !$isTree ? " active" : "" }}">
                            {{ config("site-group-price.sitePackageName") }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.groups.index') }}?view=tree"
                           class="nav-link{{ isset($isTree) && $isTree ? " active" : "" }}">
                            Приоритет
                        </a>
                    </li>
                @endcan

                @empty($group)
                    @can("create", \App\Group::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.groups.create") }}"
                               class="nav-link{{ $currentRoute === "admin.groups.create" ? " active" : "" }}">
                                Добавить
                            </a>
                        </li>
                    @endcan
                @else
                    @can("create", \App\Group::class)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ $currentRoute == 'admin.groups.create-child' ? " active" : "" }}"
                               data-toggle="dropdown"
                               href="#"
                               role="button"
                               aria-haspopup="true"
                               aria-expanded="false">
                                Добавить
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{ route('admin.groups.create') }}">
                                    Основную
                                </a>
                                @if ($group->nesting < config("site-group-price.groupNest"))
                                    <a class="dropdown-item"
                                       href="{{ route('admin.groups.create-child', ['group' => $group]) }}">
                                        Подкатегорию
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endcan

                    @can("view", $group)
                        <li class="nav-item">
                            <a href="{{ route("admin.groups.show", ["group" => $group]) }}"
                               class="nav-link{{ $currentRoute === "admin.groups.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $group)
                        <li class="nav-item">
                            <a href="{{ route("admin.groups.edit", ["group" => $group]) }}"
                               class="nav-link{{ $currentRoute === "admin.groups.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("viewAny", \App\Meta::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.groups.metas", ["group" => $group]) }}"
                               class="nav-link{{ $currentRoute === "admin.groups.metas" ? " active" : "" }}">
                                Метатеги
                            </a>
                        </li>
                    @endcan

{{--                    @can("viewAny", \App\Price::class)--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route("admin.groups.prices.index", ["group" => $group]) }}"--}}
{{--                               class="nav-link{{ strstr($currentRoute, "prices.") !== false ? " active" : "" }}">--}}
{{--                                {{ config("site-group-price.sitePriceName") }}--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

                    @can("delete", $group)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-group-{$group->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-group-{$group->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.groups.destroy', ['group' => $group]) }}"
                                          id="delete-form-group-{{ $group->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("delete")
                                    </form>
                                </template>
                            </confirm-form>
                        </li>
                    @endcan
                @endif
            </ul>
        </div>
    </div>
</div>
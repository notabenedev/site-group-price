@include("site-group-price::admin.groups.includes.pills")
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\Price::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.groups.prices.index", ["group" => $group]) }}"
                           class="nav-link{{ $currentRoute === "admin.groups.prices.index" ? " active" : "" }}">
                            {{ config("site-group-price.sitePricesName") }}
                        </a>
                    </li>
                @endcan
                @can("update", \App\Price::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.groups.prices.tree", ["group" => $group]) }}"
                               class="nav-link{{ $currentRoute === "admin.groups.prices.tree" ? " active" : "" }}">
                                Приоритет
                            </a>
                        </li>
                    @endcan


                @can("create", \App\Price::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.groups.prices.create", ["group" => $group]) }}"
                           class="nav-link{{ $currentRoute === "admin.groups.prices.create" ? " active" : "" }}">
                            Добавить
                        </a>
                    </li>
                @endcan

                @if (! empty($price))
                    @can("view", $price)
                        <li class="nav-item">
                            <a href="{{ route("admin.prices.show", ["price" => $price]) }}"
                               class="nav-link{{ $currentRoute === "admin.prices.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", \App\Price::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.prices.edit", ["price" => $price]) }}"
                               class="nav-link{{ $currentRoute === "admin.prices.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("delete", \App\Price::class)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-price-{$price->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-price-{$price->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.prices.destroy', ['price' => $price]) }}"
                                          id="delete-form-price-{{ $price->id }}"
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
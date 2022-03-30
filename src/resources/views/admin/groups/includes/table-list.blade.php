<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Заголовок</th>
            <th>Адресная строка</th>
            <th>Дочерние</th>
            @canany(["edit", "view", "delete"], \App\Group::class)
                <th>Действия</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach ($groups as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->children->count() }}</td>
                @canany(["edit", "view", "delete"], \App\Group::class)
                    <td>
                        <div role="toolbar" class="btn-toolbar">
                            <div class="btn-group mr-1">
                                @can("update", \App\Group::class)
                                    <a href="{{ route("admin.groups.edit", ["group" => $item]) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can("view", \App\Group::class)
                                    <a href="{{ route('admin.groups.show', ['group' => $item]) }}" class="btn btn-dark">
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endcan
                                @can("delete", \App\Group::class)
                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                            </div>
                            @can("update", \App\Group::class)
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-{{ $item->published_at ? "success" : "secondary" }}" data-confirm="{{ "publish-form-{$item->id}" }}">
                                        <i class="fas fa-toggle-{{ $item->published_at ? "on" : "off" }}"></i>
                                    </button>
                                </div>
                            @endcan
                        </div>
                        @can("update", \App\Group::class)
                            <confirm-form :id="'{{ "publish-form-{$item->id}" }}'" text="Это изменит статус отображения на сайте! Невозможно снять с публикации родителя, если опубликованы дочерние элементы и страницы. Невозможно опубликовать дочерний элемент, если не опубликован его родитель. " confirm-text="Да, изменить!">
                                <template>
                                    <form action="{{ route('admin.groups.publish', ['group' => $item]) }}"
                                          id="publish-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("put")
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                        @can("delete", \App\Group::class)
                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.groups.destroy', ['group' => $item]) }}"
                                          id="delete-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                    </td>
                @endcanany
            </tr>
        @endforeach
        <tr class="text-center">
            @canany(["edit", "view", "delete"], \App\Group::class)
                <td colspan="4">
            @else
                <td colspan="3">
            @endcanany

                </td>
        </tr>
        </tbody>
    </table>
</div>
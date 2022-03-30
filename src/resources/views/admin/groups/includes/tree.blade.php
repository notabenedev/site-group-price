@can("update", \App\Group::class)
    <admin-group-list :structure="{{ json_encode($groups) }}"
                         :nesting="{{ config("site-group-price.groupNest") }}"
                         :update-url="'{{ route("admin.groups.item-priority") }}'">
    </admin-group-list>
@else
    <ul>
        @foreach ($groups as $group)
            <li>
                @can("view", \App\Group::class)
                    <a href="{{ route('admin.groups.show', ['group' => $group["slug"]]) }}"
                       class="btn btn-link">
                        {{ $group["title"] }}
                    </a>
                @else
                    <span>{{ $group['title'] }}</span>
                @endcan
                <span class="badge badge-secondary">{{ count($group["children"]) }}</span>
                @if (count($group["children"]))
                    @include("site-group-price::admin.groups.includes.tree", ['groups' => $group["children"]])
                @endif
            </li>
        @endforeach
    </ul>
@endcan

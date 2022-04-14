<div class="list-group list-group-flush price__sidebar">
    @php($route =  "site.groups.show")
    @foreach ($tree as $item)
        <div class="list-group-item price__sidebar-item">
            <div>
                @if ($item->children->count())
                    <a href="{{ route($route, ["group" => $item]) }}"
                       class="price__sidebar-link price__sidebar-link_drop{{ $item->id === $group->id ? " price__sidebar-link_active" : "" }}">
                        {{ $item->title }}
                        <svg class="price__sidebar-ico">
                            <use xlink:href="#arrow-simple-bottom"></use>
                        </svg>
                    </a>
                @else
                    <a href="{{ route($route, ["group" => $item]) }}"
                       class="price__sidebar-link{{ $item->id === $group->id ? " price__sidebar-link_active" : "" }}">
                        {{ $item->title }}
                    </a>
                @endif
            </div>
            @if ($item->children->count() && ($item->id === $group->id || $item->id === $group->parent_id))
                <div class="" id="collapse-{{ $item->id }}-{{ $position }}">
                    <ul class="list-unstyled price__sidebar-children">
                        @foreach ($item->children as $child)
                            <li>
                                <a href="{{ route($route, ["group" => $child]) }}"
                                   class="price__sidebar-link price__sidebar-link_child{{ $child->id === $group->id ? " price__sidebar-link_active" : "" }}">
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endforeach
</div>
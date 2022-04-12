<div class="list-group list-group-flush price-sidebar">
    @php($route =  "site.groups.show")
    @foreach ($tree as $item)
        <div class="list-group-item price-sidebar__item">
            <div>
                @if ($item->children->count())
                    <a href="{{ route($route, ["group" => $item]) }}"
                       class="price-sidebar__link price-sidebar__link_drop{{ $item->id === $group->id ? " price-sidebar__link_active" : "" }}">
                        {{ $item->title }}
                        <svg class="price-sidebar__ico">
                            <use xlink:href="#arrow-simple-bottom"></use>
                        </svg>
                    </a>
                @else
                    <a href="{{ route($route, ["group" => $item]) }}"
                       class="price-sidebar__link{{ $item->id === $group->id ? " price-sidebar__link_active" : "" }}">
                        {{ $item->title }}
                    </a>
                @endif
            </div>
            @if ($item->children->count() && ($item->id === $group->id || $item->id === $group->parent_id))
                <div class="" id="collapse-{{ $item->id }}-{{ $position }}">
                    <ul class="list-unstyled price-sidebar__children">
                        @foreach ($item->children as $child)
                            <li>
                                <a href="{{ route($route, ["group" => $child]) }}"
                                   class="price-sidebar__link price-sidebar__link_child{{ $child->id === $group->id ? " price-sidebar__link_active" : "" }}">
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
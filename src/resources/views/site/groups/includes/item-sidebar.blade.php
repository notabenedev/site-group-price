@if (! empty($item->published_at))
    <div class="list-group-item price__sidebar-item">
        <div>
            @if ($item->children->count() && !$item->nested)
                <a href="{{ route($route, ["group" => $item]) }}"
                   class="price__sidebar-link price__sidebar-link_drop{{ $item->id === $group->id ? " price__sidebar-link_active" : "" }}">
                    {{ $item->title }}
                    <i class="fas fa-caret-down"></i>
                </a>
            @else
                <a href="{{ route($route, ["group" => $item]) }}"
                   class="price__sidebar-link{{ $item->id === $group->id ? " price__sidebar-link_active" : "" }}">
                    {{ $item->title }}
                </a>
            @endif
        </div>
        @if ($item->children->count()
        && ($item->id === $group->id || $item->id === $group->parent_id
            || (isset($group->parent->parent_id) && $item->id === $group->parent->parent_id)
            || (isset($group->parent->parent) && $item->id === $group->parent->parent->parent_id))
        && !$item->nested)
            <div class="price__sidebar-item_children" id="collapse-{{ $item->id }}">
                    @foreach ($item->children as $child)
                            @include('site-group-price::site.groups.includes.item-sidebar', ['item' => $child])
                 @endforeach
            </div>
        @endif
    </div>
@endif
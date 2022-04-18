<div class="list-group list-group-flush price__menu price__sidebar">
    @php($route =  "site.groups.show")
    @foreach ($groupsTree as $item)
        @include('site-group-price::site.groups.includes.item-sidebar', ['item' => $item])
    @endforeach
</div>
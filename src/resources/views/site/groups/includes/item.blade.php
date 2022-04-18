<div class="price__group-item price__group-item_level-{{ $level }}"  id="{{ $item["slug"]}}">
    <h3 class="h{{$level+1}} price__group-title price__group-title_level-{{ $level }}">{{ $item["title"] }}</h3>
    @isset($item['short'])
        <div class="price__group-short">
            {!! $item['short']  !!}
        </div>
    @endisset

    @foreach(\Notabenedev\SiteGroupPrice\Facades\PriceActions::getGroupPriceIds($item["id"]) as $id => $price)
        @include('site-group-price::site.groups.includes.item-price', ['id' => $id, 'loop' => $loop, 'price' => $price])
    @endforeach

    @isset($item['description'])
        <div class="price__group-description">
            {!! $item['description']  !!}
            @isset($item['accent'])
                <div class="price__group-accent">
                    {{ $item['accent'] }}
                </div>
            @endisset
        </div>
    @endisset

    @isset($item['info'])
        <div class="price__group-info">
            {!! $item['info'] !!}
        </div>
    @endisset

    @if (! empty($item["children"]))
        @foreach ($item["children"] as $child)
            @if (isset($child["published_at"]))
                @include("site-group-price::site.groups.includes.item", ["item" => $child, "first" => false, "level" => $level + 1])
            @endif
        @endforeach
    @endif
</div>




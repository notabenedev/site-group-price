<div class="price__group-item price__group-item_level-{{ $level }}"  id="{{ $item["slug"]}}">
    <h3 class="h{{$level+1}} price__group-title price__group-title_level-{{ $level }}">{{ $item["title"] }}</h3>
    @isset($item['short'])
        <div class="price__group-short">
            {!! $item['short']  !!}
        </div>
    @endisset

    @if (! empty($item["children"]))
            @foreach ($item["children"] as $child)
                @include("site-group-price::site.groups.includes.item", ["item" => $child, "first" => false, "level" => $level + 1])
            @endforeach
    @endif

    @foreach(\Notabenedev\SiteGroupPrice\Facades\PriceActions::getGroupPrice($item["id"]) as $id => $price)
        <div class="row price__list {{ ($loop->iteration % 2 == 0) ? "" : "price__list-iteration" }}">
            <div class="col-12 col-sm-7 col-md-8 col-lg-9 price__list-title" id="{{ $price["slug"]}}">
                {{ $price["title"] }}
                @isset($price["description"])
                    <div class="price__list-description">
                        {!! $price["description"]  !!}
                    </div>
                @endisset
            </div>
            <div class="col-12 col-sm-5 col-md-4 col-lg-3 price__list-price ">
                @if($price["price"]  )
                    {{ $price["price"] }}
                @endif
            </div>
        </div>
    @endforeach

    @isset($item['description'])
        <div class="price__group-description">
            {!! $item['description']  !!}
        </div>
    @endisset
    @isset($item['accent'])
        <div class="price__group-accent">
            {{ $item['accent'] }}
        </div>
    @endisset
    @isset($item['info'])
        <div class="price__group-info">
            {!! $item['info'] !!}
        </div>
    @endisset
</div>




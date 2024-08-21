<div class="price__menu">
    @if(config("site-group-price.sitePriceOnePageFile", false))
            @pic([
            "image" => (object) ["file_name" => config("site-group-price.sitePriceOnePageFile"), "name" => "Прайс"],
            "template" => "price-side",
            "grid" => [
            "price-side-xxl" => 1400,
            "price-side-xl" => 1200,
            "price-side-lg" => 992,
            "price-side-md" => 768,
            ],
            "imgClass" => "img-fluid rounded price__menu-img",
            ])
    @endif
    <ul class="list-unstyled">
        @foreach($rootGroups as $key => $item)
            <li class="price__menu-item">
                <a class="price__menu-item_link" href="#{{ $item["slug"] }}">{{ $item["title"] }}</a>
            </li>
        @endforeach
    </ul>
</div>


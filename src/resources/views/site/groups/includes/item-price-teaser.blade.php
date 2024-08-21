@if ($loop->first)
<div class="row">
@endif
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card card-base h-100 price-teaser" id="{{ $price["slug"] }}">
            @if ($price->image)
                <div class="price-image-scale">
                        @picLazy([
                        "image" => $price->image,
                        "template" => "sm-grid-12",
                        "grid" => [
                        "xl-grid-3"  => 1200,
                        "lg-grid-3"  => 992,
                        "md-grid-6"  => 768,
                        "sm-grid-6"  => 576
                        ],
                        "imgClass" => "card-img-top price-teaser__image",
                        ])
                </div>
            @endif
            <div class="card-body">
                <div class="price-teaser__title">
                    {{ $price["title"] }}
                </div>
                @if ($price->description)
                    <div class="price-teaser__description">
                        {!! $price["description"]  !!}
                    </div>
                @endif
                @if($price["price"]  )
                    <div class="price-teaser__price">
                        {{ $price["price"] }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@if ($loop->last)
</div>
@endif

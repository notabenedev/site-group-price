<div class="row price__list{{ isset($margin) ? " mx-0": "" }}{{ ($loop->iteration % 2 == 0) ? "" : " price__list-iteration" }}"
     id="{{ $price["slug"]}}">
    <div class="col-12 col-sm-7 col-md-8 col-lg-9 price__list-title">
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
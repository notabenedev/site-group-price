@php
    $active = (strstr($currentRoute, ".groups.") !== false) ||
              (strstr($currentRoute, ".price.") !== false);
@endphp

@if ($theme == "sb-admin")
    <li class="nav-item {{ $active ? " active" : "" }}">
        <a href="#"
           class="nav-link"
           data-toggle="collapse"
           data-target="#collapse-groups-menu"
           aria-controls="#collapse-groups-menu"
           aria-expanded="{{ $active ? "true" : "false" }}">
            <i class="fas fa-stream"></i>
            <span>{{ config("site-group-price.sitePackageName") }}</span>
        </a>

        <div id="collapse-groups-menu"
             class="collapse"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can("viewAny", \App\Group::class)
                    <a href="{{ route("admin.groups.index") }}"
                       class="collapse-item{{ strstr($currentRoute, ".groups.") !== false ? " active" : "" }}">
                        <span>{{ config("site-group-price.siteGroupsName") }}</span>
                    </a>
                @endcan
                @can("viewAny", \App\Price::class)
                        <a href="{{ route("admin.prices.index") }}"
                           class="collapse-item{{ strstr($currentRoute, ".prices.") !== false ? " active" : "" }}">
                            <span>{{ config("site-group-price.sitePricesName") }}</span>
                        </a>
                @endcan

            </div>
        </div>
    </li>
@else
    <li class="nav-item dropdown">
        <a href="#"
           class="nav-link dropdown-toggle{{ $active ? " active" : "" }}"
           role="button"
           id="groups-menu"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            <i class="fas fa-stream"></i>
            {{ config("site-group-price.sitePackageName") }}
        </a>

        <div class="dropdown-menu" aria-labelledby="groups-menu">
            @can("viewAny", \App\Group::class)
                <a href="{{ route("admin.groups.index") }}"
                   class="dropdown-item">
                    {{ config("site-group-price.siteGroupsName") }}
                </a>
            @endcan
            @can("viewAny", \App\Price::class)
                <a href="{{ route("admin.prices.index") }}"
                   class="dropdown-item">
                    {{ config("site-group-price.sitePricesName") }}
                </a>
            @endcan

        </div>
    </li>
@endif

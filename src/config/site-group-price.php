<?php
return [
    "groupAdminRoutes" => true,
    "groupSiteRoutes" => true,

    "groupFacade" => \Notabenedev\SiteGroupPrice\Helpers\GroupActionsManager::class,
    "priceFacade" => \Notabenedev\SiteGroupPrice\Helpers\PriceActionsManager::class,

    "siteBreadcrumbs" => false,

    "sitePackageName" => "Группы прайсов",
    "siteGroupsName" => "Группы",
    "sitePricesName" => "Позиции",

    "groupNest" => 4,
    "onePage" => true,

    "groupUrlName" => "prices",
    "priceUrlName" => "price",

];
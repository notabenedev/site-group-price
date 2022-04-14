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

    "sitePriceHeaderTitleName" => "Наименование услуги",
    "sitePriceHeaderPriceName" => "Цена (в рублях)",

    "sitePriceOnePageFile" => "",

    "groupNest" => 4,
    "onePage" => true,

    "groupUrlName" => "price",
    "priceUrlName" => "position",

];
<?php
return [
    "groupAdminRoutes" => true,
    "groupSiteRoutes" => true,

    "groupFacade" => \Notabenedev\SiteGroupPrice\Helpers\GroupActionsManager::class,

    "onePage" => true,
    "siteBreadcrumbs" => false,

    "sitePackageName" => "Группы прайсов",
    "siteGroupsName" => "Группы",
    "sitePricesName" => "Позиции",

    "groupNest" => 4,

    "groupUrlName" => "prices",
    "priceUrlName" => "price",

];
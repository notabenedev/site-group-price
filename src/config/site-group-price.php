<?php
return [
    "groupAdminRoutes" => true,
    "groupSiteRoutes" => true,

    "groupFacade" => \Notabenedev\SiteGroupPrice\Helpers\GroupActionsManager::class,

    "onePage" => true,

    "sitePackageName" => "Группы прайсов",
    "siteGroupsName" => "Группы",
    "sitePriceName" => "Прайсы",

    "groupNest" => 4,

    "groupUrlName" => "prices",
    "priceUrlName" => "price",

];
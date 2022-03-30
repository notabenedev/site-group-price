## Site group price

Копировать:
- php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=public --force
- php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=config

## Description

## Config
 
    "onePage" => true, false - вывод прайса на одной странице
    "sitePackageName" => Название пакета
    "siteGroupName" => Название групп прайсов
    "sitePriceName" => Название прайса

    "groupNest" => число - вложенность групп прайсов,

    "groupUrlName" => url групп прайсов
    "priceUrlName" => url прайса
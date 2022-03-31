## Site group price

## Install

- php artisan migrate
- php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=public --force
- php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=config
- php artisan make:group-price 
{--all : Run all}
{--menu : admin menu}
{--models : Export models}
{--controllers : Export controllers}
{--policies : Export and create rules}
{--only-default : Create default rules}
{--vue : Export Vue components}

## Description

## Config
 
    "onePage" => true, false - вывод прайса на одной странице
    "sitePackageName" => Название пакета
    "siteGroupName" => Название групп прайсов
    "sitePriceName" => Название прайса

    "groupNest" => число - вложенность групп прайсов,

    "groupUrlName" => url групп прайсов
    "priceUrlName" => url прайса
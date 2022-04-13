## Site group price

## Install

- php artisan migrate
- php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=public --force
- php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=config
- php artisan make:group-price 
{--all : Run all}
{--menu : admin menu}
{--models : Export models}
{--observers : Export observers}
{--controllers : Export controllers}
{--policies : Export and create rules}
{--only-default : Create default rules}
{--vue : Export Vue components}

## Description

## Config
    
    "groupAdminRoutes" => true, false
    "groupSiteRoutes" => true, false
    
    "groupFacade" => переопределение фасада групп (::class)
    "priceFacade" => переопределение фасада позиций (::class)
    
    "sitePackageName" => Название пакета
    
    "sitePackageName" => Название пакета,
    "siteGroupsName" =>  Название групп прайсов
    "sitePricesName" => Название позиций прайса
    "sitePriceHeaderTitleName" => Название столбика с заголовком позиции прайса
    "sitePriceHeaderPriceName" => Название столбика с ценой позиции прайса
    
    "groupNest" => число (вложенность групп прайсов),
    "onePage" => true, false -Ракрытие всех групп и позиций на одной странице
     
    "groupUrlName" => url групп прайсов
    "priceUrlName" => url прайса
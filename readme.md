## Site group price

## Конфиг
    php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=config

## Install
    php artisan migrate
    php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=public --force
    php artisan make:group-price
          {--all : Run all}
          {--menu : admin menu}
          {--models : Export models}
          {--observers : Export observers}
          {--controllers : Export controllers}
          {--policies : Export and create rules}
          {--only-default : Create default rules}
          {--vue : Export Vue components}

## Description
    v0.1.0 add image to price & config param usePriceImage
        - php artisan migrate
        - php artisan config:clear
        - php artisan cache:clear
        - проверить переопределение Admin/PriceController (>create, >update, >validate) и соответствующих шаблонов
        - проверить переопределение Site/GroupController (>show - add $template) и соответствующего шаблона
        - проверить переопределение модели Price        
    v0.0.9 add group metas
    v0.0.8 fix price__group margin
        php artisan vendor:publish --provider="Notabenedev\SiteGroupPrice\SiteGroupPriceProvider" --tag=public --force
    v0.0.7 siteBreadcrumbs config
        use variable to show breadcrumb
    v0.0.6 fix publishCascade, fix  admin group menu (srt active)
    v0.0.5 fix publishCascade, fix  price policy

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
    "onePage" => true, false - Ракрытие всех групп и позиций на одной странице:
     (перед изменением настройки:
      - php artisan down
      - открыть url главной страницы раздела
      - изменить настройку
      - php artisan up
      - открыть url главной страницы раздела
     
    "groupUrlName" => url групп прайсов
    "priceUrlName" => url прайса


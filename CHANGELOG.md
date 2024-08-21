## Versions
    v1.0.0: base-settings 5 (bootstrap 5)
        - new filter: price-side-xxl
        - change style
        - change views: admin.menu, admin.price.index
        - change views: site.groups.includes.*

    v0.1.1-0.1.2: id to price-teaser, price__list
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


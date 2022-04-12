<?php

namespace Notabenedev\SiteGroupPrice\Console\Commands;

use App\Menu;
use App\MenuItem;
use Illuminate\Console\Command;
use PortedCheese\BaseSettings\Console\Commands\BaseConfigModelCommand;

class GroupPriceMakeCommand extends BaseConfigModelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:group-price
     {--all : Run all}
     {--menu : Config menu}
     {--models : Export models}
     {--observers : Export observers}
     {--controllers : Export controllers}
     {--policies : Export and create rules} 
     {--vue : Export vue}
     {--only-default : Create only default rules}
     ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settings for groups and prices';

    /**
     * Vendor Name
     * @var string
     *
     */
    protected $vendorName = 'Notabenedev';

    /**
     * Package Name
     * @var string
     *
     */
    protected $packageName = 'SiteGroupPrice';

    /**
     * The models to  be exported
     * @var array
     */
    protected $models = ["Group", "Price"];

    /**
     * Создание наблюдателей
     *
     * @var array
     */
    protected $observers = ["GroupObserver", "PriceObserver"];


    /**
     * Make Controllers
     */
    protected $controllers = [
        "Admin" => ["GroupController", "PriceController"],
        "Site" => ["GroupController"],
    ];

    /**
     * Policies
     * @var array
     *
     */
    protected $ruleRules = [
        [
            "title" => "Группы прайса",
            "slug" => "groups",
            "policy" => "GroupPolicy",
        ],
        [
            "title" => "Цены прайса",
            "slug" => "prices",
            "policy" => "PricePolicy",
        ],

    ];

    /**
     * Vue files folder
     *
     * @var string
     */
    protected $vueFolder = "site-group-price";

    /**
     * Vue files list
     *
     * @var array
     */
    protected $vueIncludes = [
        'admin' => [ 'admin-group-list' => "GroupListComponent",
        ],
        'app' => [],
    ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all = $this->option("all");


        if ($this->option("models") || $all) {
            $this->exportModels();
        }

        if ($this->option("observers") || $all) {
            $this->exportObservers();
        }

        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
            $this->exportControllers("Site");
        }

        if ($this->option('menu') || $all) {
            $this->makeMenu();
        }

        if ($this->option("policies") || $all) {
            $this->makeRules();

        }

        if ($this->option("vue") || $all) {
            $this->makeVueIncludes("admin");
            $this->makeVueIncludes("app");
        }

    }

    /**
     * Создать меню.
     */
    protected function makeMenu()
    {
        try {
            $menu = Menu::query()->where("key", "admin")->firstOrFail();
        }
        catch (\Exception $exception) {
            return;
        }

        $title = config("site-group-price.sitePackageName");
        $itemData = [
            "title" => $title,
            "menu_id" => $menu->id,
            "url" => "#",
            "template" => "site-group-price::admin.menu",
        ];

        try {
            $menuItem = MenuItem::query()
                ->where("menu_id", $menu->id)
                ->where("title", "$title")
                ->firstOrFail();
            $this->info("Menu item '{$title}' not updated");
        }
        catch (\Exception $exception) {
            MenuItem::create($itemData);
            $this->info("Menu item '{$title}' was created");
        }
    }
}

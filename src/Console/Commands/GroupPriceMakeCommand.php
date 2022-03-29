<?php

namespace Notabenedev\SiteGroupPrice\Console\Commands;

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
     {--models : Export models}
     {--controllers : Export controllers}
     {--policies : Export and create rules} 
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
    protected $models = ["Group"];

    /**
     * Make Controllers
     */
    protected $controllers = [
        "Admin" => ["GroupController"],
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

        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
        }

        if ($this->option("policies") || $all) {
            $this->makeRules();

        }

    }
}

<?php

namespace notabenedev\SiteGroupPrice\Console\Commands;

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
    protected $vendorName = 'notabenedev';

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
        return 0;
    }
}

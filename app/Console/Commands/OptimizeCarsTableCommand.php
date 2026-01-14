<?php


namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\CarOptimizationController;
use Illuminate\Support\Facades\Log;
class OptimizeCarsTableCommand extends Command
{
    protected $signature = 'cars:optimize';
    protected $description = 'Optimize cars table by standardizing make, fuel_type, gear_box, and colors columns';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        try {
            $controller = new CarOptimizationController();
            $controller->optimizeCarsTable();
            $this->info('Cars table optimization completed successfully.');
           
        } catch (\Exception $e) {
            $this->error('An error occurred during optimization: ' . $e->getMessage());
           
        }
    }
}
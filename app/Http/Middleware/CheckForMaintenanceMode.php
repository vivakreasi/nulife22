<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as MaintenanceMode;

class CheckForMaintenanceMode {

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() &&
//            !in_array($request->getClientIp(), ['36.74.10.17','139.195.193.228','36.79.246.110','36.84.42.230','125.165.125.194','114.125.12.91','115.178.234.108','36.84.42.230','114.125.119.127','110.136.104.49','36.79.246.110','180.247.137.118','114.123.73.10','36.78.115.106','36.74.10.17','110.136.104.49']))
            !in_array($request->getClientIp(), ['36.74.10.17','139.195.193.228']))
        {
            $maintenanceMode = new MaintenanceMode($this->app);
            return $maintenanceMode->handle($request, $next);
        }

        return $next($request);
    }

}
<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pengabdian;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$routeName = 'pengabdian-dos.laporan-akhir.view-reviews';

echo "Checking Route: $routeName\n";

if (Route::has($routeName)) {
    echo "Route Exists!\n";
    try {
        $url = route($routeName, ['pengabdian_id' => 123, 'review_number' => 1]);
        echo "Generated URL: $url\n";
    } catch (\Exception $e) {
        echo "Error generating URL: " . $e->getMessage() . "\n";
    }
} else {
    echo "Route does NOT exist.\n";

    echo "Updating route cache list...\n";
    // Check registered routes
    $routes = Route::getRoutes();
    foreach ($routes as $route) {
        if (str_contains($route->getName(), 'pengabdian')) {
            echo "Found similar route: " . $route->getName() . " -> " . $route->uri() . "\n";
        }
    }
}

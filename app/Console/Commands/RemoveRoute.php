<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RemoveRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:route {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove generated page';

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
        $name = $this->argument('name');

        $this->removeBlade($name);
        $this->removeControllerRoute($name);
        $this->removeRoute($name);

        return true;
    }

    public function removeBlade($name)
    {
        $path = app_path("../resources/views/generated-view/{$name}.blade.php");

        if (!File::exists($path)) {
            $this->error("File {$path} not found!");
            return;
        }
        File::delete($path);
    }

    public function removeControllerRoute($name)
    {
        $controllerPath = app_path('Http/Controllers/AutoGenerate/GeneratedViewController.php');
        $content = File::get($controllerPath);
        $replace =
            "public function " . $name . "()\n" .
            "    {\n" .
            '        $content = Pages::where(\'name\', \'=\', "' . $name . '")->first();' . "\n\n" .
            '        return view(\'generated-view.' . $name . '\', [\'content\' => $content]);' . "\n" .
            "    }\n" .
            "\n";

        $result = str_replace($replace, "\n", $content);

        File::put($controllerPath, $result);
    }

    public function removeRoute($name)
    {
        $routesPath = app_path('../routes/auto-generated/web.php');
        $content = File::get($routesPath);
        $replace = "Route::get('/" . Str::snake($name) . "', 'AutoGenerate\GeneratedViewController@" . $name . "');\n";
        $result = str_replace($replace, "", $content);

        File::put($routesPath, $result);
    }
}

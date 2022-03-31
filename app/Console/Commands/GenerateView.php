<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateView extends Command
{
    public string $tab = "    ";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new blade template.';

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
     * @return mixed
     */
    public function handle(): void
    {
        $view = $this->argument('view');

        $path = $this->viewPath($view);

        $this->createDir($path);

        if (File::exists($path)) {
            $this->error("File {$path} already exists!");
            return;
        }

        $this->generateNewView($path);
        $this->addNewRouteInController($view);
        $this->addNewRoute($view);

        $this->info("File {$path} created.");
    }

    public function generateNewView($path)
    {
        File::put($path,
            "@extends('layouts.app')\n@section('title', 'Синий утёс')\n@section('content')
    <p style='text-align: center; margin-top: 50px;'>Hello it's you're generated page</p>\n@endsection()");
    }

    /**
     * Get the view full path.
     *
     * @param string $view
     *
     * @return string
     */
    public function viewPath(string $view): string
    {
        $view = str_replace('.', '/', $view) . '.blade.php';

        return "resources/views/generated-view/{$view}";
    }

    /**
     * @return void
     */
    public function addNewRoute($view)
    {
        $routesPath = 'routes/auto-generated/web.php';
        $content = File::get($routesPath);
        $replace = "Route::get('/" . $view . "', 'GeneratedViewController@" . $view . "');\n\n//placeForAutoGenerateRoute";
        $result = str_replace('//placeForAutoGenerateRoute', $replace, $content);

        File::put($routesPath, $result);
    }

    /**
     * @param $view
     * @return void     */
    public function addNewRouteInController($view)
    {
        $controllerPath = 'app/Http/Controllers/AutoGenerate/GeneratedViewController.php';
        $content = File::get($controllerPath);
        $replace =
            "public function " . $view . "()\n" .
            "    {\n" .
            "        return view('generated-view." . $view . "');\n" .
            "    }\n" .
            "\n" .
            "    //placeForAutoGenerate";

        $result = str_replace('//placeForAutoGenerate', $replace, $content);

        File::put($controllerPath, $result);
    }

    /**
     * Create view directory if not exists.
     *
     * @param $path
     */
    public function createDir($path)
    {
        $dir = dirname($path);

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }

}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GenerateRoute extends Command
{
    public string $tab = "    ";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:route {name}';

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
     * @return bool
     */
    public function handle(): bool
    {
        try {
            $name = $this->argument('name');
            $this->generateNewView($name);
            $this->addNewRouteInController($name);
            $this->addNewRoute($name);

            return true;
        } catch (\Exception $e) {
            dd([
                $e->getMessage(),
                $e->getFile()
            ]);
            Log::debug('create view error', [
                'Message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile(),
            ]);
            return false;
        }
    }

    /**
     * @param $name
     * @return void
     */
    public function generateNewView($name)
    {
        $path = $this->viewPath($name);

        $this->createDir($path);

        if (File::exists($path)) {
            $this->error("File {$path} already exists!");
            return;
        }

        File::put($path, "@extends('layouts.app')\n@section('title', 'Синий утёс')\n@section('content')
    <p style='text-align: center; margin-top: 50px;'>Hello it's you're generated page</p>\n@endsection()");

    }


    /**
     * @param $name
     * @return void
     */
    public function addNewRoute($name)
    {
        $routesPath = app_path('../routes/auto-generated/web.php');
        $content = File::get($routesPath);
        $replace = "Route::get('/" . Str::snake($name) . "', 'AutoGenerate\GeneratedViewController@" . $name . "');\n\n//placeForAutoGenerateRoute";
        $result = str_replace('//placeForAutoGenerateRoute', $replace, $content);

        File::put($routesPath, $result);
    }

    /**
     * @param $name
     * @return void
     */
    public function addNewRouteInController($name)
    {
        $controllerPath = app_path('Http/Controllers/AutoGenerate/GeneratedViewController.php');
        $content = File::get($controllerPath);
        $replace =
            "public function " . $name . "()\n" .
            "    {\n" .
            "        return view('generated-view." . $name . "');\n" .
            "    }\n" .
            "\n" .
            "    //placeForAutoGenerate";

        $result = str_replace('//placeForAutoGenerate', $replace, $content);

        File::put($controllerPath, $result);
    }

    /**
     * Get the view full path.
     *
     * @param string $name
     *
     * @return string
     */
    public function viewPath(string $name): string
    {
        $name = str_replace('.', '/', $name) . '.blade.php';

        return app_path("../resources/views/generated-view/{$name}");
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

<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ex:make';

    protected $class;
    protected $name;
    protected $validation;
    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make (Model, Controller, Migration, Seeder, Route, View)';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->files = app('files');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->class = Str::studly($this->ask('What is the Class name ex.abc'));
        $this->name = strtolower($this->class);
        $table = Str::plural(Str::snake(class_basename($this->class)));
        $this->info('Creating Migration...');
        if ($this->confirm('Do you wish to create Migration ?')) {
            $this->callSilent('make:migration', [
                'name' => "create_{$table}_table",
                '--create' => $table,
            ]);
        }
        if ($this->confirm('Do you wish to create Model ?')) {
            $this->createModel();
        }
        if ($this->confirm('Do you wish to create Controller ?')) {
            $this->createController();
        }
        if ($this->confirm('Do you wish to create filtration ?')) {
            $this->createFiltration();
        }
        if ($this->confirm('Do you wish to create seeder ?')) {
            $this->callSilent('make:seeder', [
                'name' => Str::plural($this->class) . 'TableSeeder',
            ]);
            $this->registerSeederFile();
        }
        // create observer
        if ($this->confirm('Do you wish to create observer ?')) {
            $this->createObserver();
            $this->registerObserverFile();

        }
        if ($this->confirm('Do you wish to create routes ?')) {
            $this->createRoute();
        }
        if ($this->confirm('Do you wish to create form request ?')) {
            $this->createRequest();
        }
        if ($this->confirm('Do you wish to create views ?')) {
            $this->createView();
        }

        // composer dump-autoload
        shell_exec('composer dump-autoload');
        $this->info('All Done');
        return;


        // create controller
        if ($this->confirm('Do you wish to create controller ?')) {
            $this->createController();
        }
        // create migration
        if ($this->confirm('Do you wish to create a Migration File ?')) {
            $table = Str::plural(Str::snake(class_basename($this->class)));
            $this->callSilent('make:migration', [
                'name' => "create_{$table}_table",
                '--create' => $table,
            ]);
        }

        // create model
        $this->createModel();

        // create a seeder
        if ($this->confirm('Do you wish to create & register a DB Seeder ?')) {
            $this->callSilent('make:seeder', [
                'name' => Str::plural($this->class) . 'TableSeeder',
            ]);

            $this->registerSeederFile();
        }

        // create routes
        if ($this->confirm('Do you wish to add Routes ?')) {
            $this->createRoute();
        }

        // create views
        if ($this->confirm('Do you wish to include Views ?')) {
            $this->createView();
        }

        // composer dump-autoload
        shell_exec('composer dump-autoload');

        $this->info('All Done');
    }

    /**
     * [createRMB description].
     *
     * @return [type] [description]
     */
    protected function createController()
    {
        $dir = app_path('Http/Controllers');
        $this->checkDirExistence($dir);

        $controller = $this->class . 'Controller';

        if (!$this->files->exists("$dir/$controller.php")) {
            $stub = $this->files->get(__DIR__ . '/stubs/controller/create.stub');

            $class = str_replace('DummyClass', $controller, $stub);
            $model = str_replace('DummyModelClass', $this->class, $class);
            $view = str_replace('DummyName', $this->name, $model);

            $this->files->put("$dir/$controller.php", $view);
        }
    }

    /**
     * [createRMB description].
     *
     * @return [type] [description]
     */
    protected function createObserver()
    {
        $dir = app_path('Observers');
        $this->checkDirExistence($dir);

        $observer = $this->class . 'Observer';

        if (!$this->files->exists("$dir/$observer.php")) {
            $stub = $this->files->get(__DIR__ . '/stubs/observer/create.stub');

            $class = str_replace('DummyClass', $observer, $stub);
            $model = str_replace('DummyModelClass', $this->class, $class);
            $view = str_replace('DummyName', $this->name, $model);

            $this->files->put("$dir/$observer.php", $view);
        }
    }

    /**
     * [createModel description].
     *
     * @return [type] [description]
     */
    protected function createModel()
    {
        $dir = app_path('Models');
        $this->checkDirExistence($dir);

        // create model
        if (!$this->files->exists("$dir/$this->class.php")) {
            $stub = $this->files->get(__DIR__ . '/stubs/model/create.stub');
            $class = str_replace('DummyClass', $this->class, $stub);

            $this->files->put("$dir/$this->class.php", $class);
        }
    }

    /**
     * [registerSeederFile description].
     *
     * @return [type] [description]
     */
    protected function registerSeederFile()
    {
        $stub = $this->files->get(__DIR__ . '/stubs/db/seeder.stub');
        $seed = str_replace('DummySeed', Str::plural($this->class), $stub);
        $dir = database_path('seeders/DatabaseSeeder.php');

        if (!Str::contains($this->files->get($dir), Str::plural($this->class))) {
            $file = file($dir);
            for ($i = 0; $i < count($file); ++$i) {
                if (strstr($file[$i], '// data')) {
                    $file[$i] = $file[$i] . $seed;
                    break;
                }
            }

            return $this->files->put($dir, $file);
        }
    }

    /**
     * [createRoute description].
     *
     * @return [type] [description]
     */
    protected function createRoute()
    {
        $dir = base_path('routes/Routes');
        $this->checkDirExistence($dir);

        if (!$this->files->exists("$dir/$this->class.php")) {
            $stub = $this->files->get(__DIR__ . '/stubs/route/create.stub');
            $name = str_replace('DummyName', $this->name, $stub);
            $class = str_replace('DummyClass', $this->class, $name);

            $this->files->put("$dir/$this->class.php", $class);
        }
    }

    /**
     * [createRoute description].
     *
     * @return [type] [description]
     */
    protected function createRequest()
    {
        $dir = base_path('app/Http/Requests');
        $this->checkDirExistence($dir);

        if (!$this->files->exists("$dir/$this->class.php")) {
            $stub = $this->files->get(__DIR__ . '/stubs/request/create.stub');
            $name = str_replace('DummyName', $this->name, $stub);
            $class = str_replace('DummyClass', $this->class, $name);

            $this->files->put("$dir/$this->class" . "Request.php", $class);
        }
    }

    /**
     * [createRoute description].
     *
     * @return [type] [description]
     */
    protected function createFiltration()
    {
        $dir = base_path('app/Http/Controllers/Traits/' . $this->class);
        $this->checkDirExistence($dir);

        if (!$this->files->exists("$dir/Filtration.php")) {
            $stub = $this->files->get(__DIR__ . '/stubs/filtration.stub');
            $class = str_replace('DummyClass', $this->class, $stub);

            $this->files->put("$dir/" . "Filtration.php", $class);
        }
    }

    /**
     * [createView description].
     *
     * @return [type] [description]
     */
    protected function createView()
    {
        $dir = resource_path("views/pages/$this->name" . "s");
        $this->checkDirExistence($dir);
        $this->checkDirExistence($dir . '/partials');

        $methods = [
            'index',
            'info',
            'create',
            'show',
            'edit',
            'form',
        ];

        foreach ($methods as $one) {
            if (!$this->files->exists("$dir/$one.blade.php")) {
                $stub = $this->files->get(__DIR__ . '/stubs/view/' . $one . '.stub');
                $view = str_replace('DummyClass', $this->class, $stub);
                $view = str_replace('DummyRoute', $this->name, $view);
                if (in_array($one, ['info', 'form'])) {
                    $this->files->put("$dir/partials/$one.blade.php", $view);
                } else {
                    $this->files->put("$dir/$one.blade.php", $view);
                }
            }
        }
    }

    /**
     * [checkDirExistence description].
     *
     * @param [type] $dir [description]
     *
     * @return [type] [description]
     */
    protected function checkDirExistence($dir)
    {
        if (!$this->files->exists($dir)) {
            return $this->files->makeDirectory($dir, 0755, true);
        }
    }

    private function registerObserverFile()
    {
        $stub = $this->files->get(__DIR__ . '/stubs/observer.stub');
        $observer = str_replace('DummyModel', $this->class, $stub);
        $dir = base_path('app/Providers/AppServiceProvider.php');
        $file = file($dir);
        for ($i = 0; $i < count($file); ++$i) {
            if (strstr($file[$i], 'observe')) {
                $file[$i] = $file[$i] . $observer;
                break;
            }
        }

        return $this->files->put($dir, $file);
    }
}

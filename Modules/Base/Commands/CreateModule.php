<?php

namespace Module\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $path = base_path('src/Modules');
        $name = $this->argument('name');
        $class = Str::ucfirst($name);
        $lower_module_name = Str::lower($class);
        $this->info('|--------------------------------------------------------------------------');
        $this->info('| Generating Module ');
        $this->info('| '.$class.' ');
        $this->info('|--------------------------------------------------------------------------');

        $dirs = [
            'config',
            'Providers',
            'resources/views',
            'routes'
        ];
        foreach($dirs as $dir){
            $directory = $path.DIRECTORY_SEPARATOR.$class.DIRECTORY_SEPARATOR.$dir;
            $this->info('| Creating Directory '.$directory);
            $this->makedirs($directory);
        }
        $stub =$path.DIRECTORY_SEPARATOR.'Base'.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'Provider.stub';
        $stub = file_get_contents($stub);
        $stub = str_replace(
            [
            '{{ module_name }}',
            '{{ lower_module_name }}'
            ],
            [
                $class,
                $lower_module_name
            ],
        $stub);
        $providerClass = $path.DIRECTORY_SEPARATOR.$class.DIRECTORY_SEPARATOR.'Providers'.DIRECTORY_SEPARATOR.$class.'ServiceProvider.php';
        if(! file_exists($providerClass)){
            file_put_contents($providerClass, $stub);
        }
        $this->info('| add the service provider in config/app.php Module\\'.$class.'\Providers\\'.$class.'ServiceProvider::class');
    }

    public function makedirs($dirpath, $mode=0777) {
        return is_dir($dirpath) || mkdir($dirpath, $mode, true);
    }
}

<?php

namespace Module\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-modules';

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
        $modules = File::directories($path);
        foreach($modules as $module){
            $this->newLine();
            $details = 'Module\\'.basename($module).'\\Providers\\'.basename($module).'ServiceProvider';
            $this->components->twoColumnDetail('  <fg=green;options=bold>'.basename($module).'</>');
            if(class_exists($details)){
                foreach($details::module() as $key => $value){
                    $this->components->twoColumnDetail($key, value($value));
                }
            }

        }
    }
}

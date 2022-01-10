<?php

namespace ItCorner\Auth\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ItCornerAuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It-Corner authentication package installation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Installing Auth package....");
        $this->info("Publishing route web....");
        if(!$this->routeExist('web.php'))
        {
            $this->publishRoute();
            $this->info('Published route web');
        }
        else
        {
            if($this->shouldOverwriteWeb())
            {
                $this->info('overwriting route web file....');
                $this->publishRoute($force = true);
            }
            else{
                $this->info('Existing route web was not overritten');
            }
        }
        $this->info('Installed Package');
    }

    private function routeExist($fileName)
    {
        return File::exists('routes/'.$fileName);
    }
    private function shouldOverwriteWeb()
    {
        return $this->confirm(
            'Route web file already exists. Do you want to overwrite if?',
            false
        );

    }
    private function publishRoute($forcePublish = false)
    {
        $param = [
            '--route'=>"ItCorner\Auth\ItCornerAuthServiceProvider",
            '--tag'=>"auth"
        ];
        if($forcePublish === true)
        {
            $params['--force']=true;
        }
        $this->call('vendor:publish',$params);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DownloadServiceKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download-service-keys {serviceName} {downloadUrl}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the service credentials keys file';

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
    public function handle()
    {
        $service = $this->argument('serviceName');

        $downloadUrl = $this->argument('downloadUrl');

        $path = '';
        switch(strtolower($service)){
            case 'firebase': $path = 'Services/Firebase/Keys/credentials.encrypt'; break;
            default: return $this->error('Service not defined');
        }
        $path = app_path($path);
        file_put_contents($path, fopen($downloadUrl, 'r'));

        if(!file_exists($path))
            return $this->error('It was not possible to download the file');

        $this->info('The credential keys file was downloaded with success');
    }
}

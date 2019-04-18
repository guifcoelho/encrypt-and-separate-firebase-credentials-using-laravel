<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Defuse\Crypto\File;
use Dotenv\Dotenv;

class EncryptServiceKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encrypt-service-key {serviceName} {serviceKeyFileName} {outputFileName} {encryptPassword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt service credentials file';

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

        $inputFile = $this->argument('serviceKeyFileName');

        $pathInputFile = app_path("Services/{$service}/Keys/{$inputFile}");

        if(!file_exists($pathInputFile))
            return $this->error("File '{$pathInputFile}' not found");

        $outputFile = "{dirname($pathInputFile)}/{$this->argument('outputFileName')}";

        $encryptPassword = $this->argument('encryptPassword');
        if($encryptPassword == null)
            return $this->error('Passwork not defined');

        File::encryptFileWithPassword($pathInputFile, $outputFile, $encryptPassword);

        if(!file_exists($outputFile)){
            return $this->error("Failed to encrypt '{$pathInputFile}'");
        }
        return $this->info("File '{$pathInputFile}' encrypted into '{$outputFile}'");
    }
}

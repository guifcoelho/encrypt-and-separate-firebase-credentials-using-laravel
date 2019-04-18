<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Defuse\Crypto\File;
use Dotenv\Dotenv;

class DecryptServiceKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'decrypt-service-keys {serviceName} {inputFileName} {outputFileName} {passwordEnv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrypt service credentials file';

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

        $inputFile = $this->argument('inputFileName');
        
        $pathInputFile = app_path("Services/{$service}/Keys/{$inputFile}");

        if(!file_exists($pathInputFile))
            return $this->error("File '{$pathInputFile}' not found");

        $outputFile = dirname($pathInputFile)."/{$this->argument('outputFileName')}";

        $passwordEnv = $this->argument('passwordEnv');
        if($passwordEnv == null)
            return $this->error('Password environment variable not found');
    
        switch(strtolower($service)){
            case 'firebase': $password = config('services.firebase.encryption_password'); break;
            default: return $this->error('Service not defined');
        }

        try{
            File::decryptFileWithPassword($pathInputFile, $outputFile, $password);
        }catch(\Exception $e){
            return $this->error("File '{$pathInputFile}' was not decrypted");
        }
        
        return $this->info("File '{$pathInputFile}' decrypted into '{$outputFile}'");
    } 
}

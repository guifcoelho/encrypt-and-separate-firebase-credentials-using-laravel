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
    protected $signature = 'decrypt-service-keys {serviceName} {outputFileName}';

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

        $encryptedFile = app_path("Services/{$service}/Keys/credentials.encrypt");
        
        if($service == "Firebase"){
            $downloadUrl = config('services.firebase.credentials_file_url');
            $password = config('services.firebase.encryption_password');
        }else{
            return $this->error('Service not defined');
        }

        if($downloadUrl == null || empty($downloadUrl) || $downloadUrl == ''){
            return $this->error('Download url not defined');
        }

        if($password == null || empty($password) || $password == ''){
            return $this->error('Decryption password not defined');
        }

        try{
            file_put_contents($encryptedFile, fopen($downloadUrl, 'r'));
        }catch(\Exception $e){
            return $this->error('It was not possible to download the file');
        }

        if(!file_exists($encryptedFile))
            return $this->error("File '{$pathInputFile}' not found");

        $outputFile = dirname($encryptedFile)."/{$this->argument('outputFileName')}";

        try{
            File::decryptFileWithPassword($encryptedFile, $outputFile, $password);
            unlink($encryptedFile);
        }catch(\Exception $e){
            return $this->error("File '{$encryptedFile}' was not decrypted");
        }
        
        return $this->info("File '{$encryptedFile}' decrypted into '{$outputFile}'");
    } 
}

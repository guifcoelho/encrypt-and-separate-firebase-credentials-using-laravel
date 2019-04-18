<?php

namespace App\Services\Firebase\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Http\UploadedFile;

class FirebaseController
{

    /**
     * The Firebase connection
     */
    private $bucket;

    /**
     * Create a new Firebase instance.
     *
     * @return void
     */
    public function __construct()
    {
        $serviceAccount = ServiceAccount::discover();
        $firebase = (new Factory)->create();
        $storage = $firebase->getStorage();
        $this->bucket = $storage->getBucket();
    }

    public function putFile(UploadedFile $file, String $ref): bool
    {
        if(
            $ref == '' || empty($ref) || $ref == null ||
            empty($file) || $file == null || !$file->isValid()
        ){ 
            return false; 
        }

        $this->bucket->upload(
            fopen($file, 'r'),
            [
                'name' => $ref
            ]
        );

        return true;
    }
}
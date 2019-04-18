<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\Firebase\Controllers\FirebaseController;
use Illuminate\Http\UploadedFile;

class FirebaseTest extends TestCase
{
    /**
     * Tests the connection with Firebase
     *
     * @return void
     */
    public function test_Firebase_storage()
    {
        $name = 'upload.jpg';
        $file_to_upload =  UploadedFile::fake()->create('upload.jpg',100);

        $upload = (new FirebaseController())->putFile($file_to_upload, "test/{$name}");

        $this->assertTrue($upload);
    }
}

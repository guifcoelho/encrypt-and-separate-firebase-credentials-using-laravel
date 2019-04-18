## Encrypt and separate your Firebase credentials json file from your Laravel project code base

<center>
<a href="https://travis-ci.com/guifcoelho/encrypt-and-separate-firebase-credentials-using-laravel"><img src="https://travis-ci.com/guifcoelho/encrypt-and-separate-firebase-credentials-using-laravel.svg?branch=master" alt="Build Status"></a>
</p>
</center>

Learn how to deploy a Laravel-Firebase app without the credentials keys in the code base.

### Laravel
1. Install Laravel with `composer create-project --prefer-dist laravel/laravel [project]`
1. Run `composer require defuse/php-encryption kreait/firebase-php` to install the encryption library and the Firebase PHP SDK
1. Create folders 'app/Services/Firebase/Controllers' and 'app/Services/Firebase/Keys' to add Firebase controllers and keys
1. Change the 'config/services.php' file, adding at the end:
```
'firebase' => [
    'encryption_password' => env('FIREBASE_KEY_ENCRYPTION_PASSWORD'),
    'credentials_file_url' => env('FIREBASE_CREDENTIALS_FILE_URL'),
],
```
1. Add 'FIREBASE_KEY_ENCRYPTION_PASSWORD', 'FIREBASE_CREDENTIALS', and 'FIREBASE_CREDENTIALS_FILE_URL' to your .env file
1. Run `encrypt-service-keys Firebase [credentials.json] [new_file].encrypt [encryption password]` to encrypt the Firebase credentials json file
1. Save the encrypted file in a public repository

### composer.json
1. In the composer.json file, add command into 'post-autoload-dump': `"@php artisan decrypt-service-keys Firebase credentials.json"`

### Travis-CI
1. Create Travis .yml file
1. Add 'APP_KEY', 'FIREBASE_KEY_ENCRYPTION_PASSWORD', 'FIREBASE_CREDENTIALS', and 'FIREBASE_CREDENTIALS_FILE_URL' into the environment variables
1. Run tests

### Heroku
1. Create app on Heroku
1. Run `heroku buildpacks:set heroku/php`
1. Add 'APP_KEY', 'FIREBASE_KEY_ENCRYPTION_PASSWORD', 'FIREBASE_CREDENTIALS', and 'FIREBASE_CREDENTIALS_FILE_URL' into the environment variables
1. Create Procfile
1. Run `composer require --dev heroku/heroku-buildpack-php`


## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

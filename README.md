# Base Module

add src directory
````bash
$ mkdir src
````

add psr-4 ````composer.json````
````json
    "autoload": {
        "psr-4": {
            ...
            "Module\\":"src/Modules/"
        }
    },
````
run 

```` $ composer update ```` or ```` $ composer dump-autoload ````

````bash 
$ cd src 
$ git clone https://github.com/anggagewor/Base.git
````

add into ````config/app.php````
````php
'providers' => ServiceProvider::defaultProviders()->merge([
 ...
 Module\Base\Providers\BaseServiceProvider\BaseServiceProvider::class,
 ...
 ])->toArray(),
 ````

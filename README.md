# Example php class for creating an Quick Install App for Hestia CP

In Hestia CP 1.4 we have decided to improve the Quick installer "App" to enable more flexibility in the near feature. 
With the new system users can simply upload a folder into /usr/local/hestia/web/src/app/WebApp/Installers/ and if the folder (AppName) contains a file name AppNameSetup.php it will add to the available apps list. 

## Creating new apps

The example that can be found should be enough to create a simple Quick install app. 

Please note currently installing via composer or archive is currently supported. 

Also make sure to prevent any issues in the future that all commands are executed as the user. Instead the root user or admin user. All the commands that are supplied by HestiaCP do this by default.

Please be aware that the naming of your WebApp should follow the following regex: [a-zA-Z][a-zA-Z0,9] otherwise it will not register as a working app!

## Changelog

### 1.6.0

- Added support for listing php versions and improved template support
- Add option to use wp-cli to install certain tasks

List the supported PHP versions in an array when averrable Hestia will always select the last php version supported.

```
'php' => [
    'supported' => [ '7.4','8.0','8.1' ],
]
```

 

### 1.5.5

- Added support for including templates in Quick install app (Optional)

```
'server' => [
    'nginx' => [
        'template' => 'example',
    ],
    'apache2' => [
        'template' => 'example',
    ],
],
```

Will load "example" template when activated. When left blank the template will be kept the same as it is currenlty. 

It is currently not possible to include the template in the Quick install app it self. And the file allready needs to exist in /usr/local/hestia/data/templates/web/{webserver}/php-fpm/

### 1.4.0

- Improved autoloading system. It will list by default all the available apps in /usr/local/hestia/web/src/app/WebApp/Installers/

#### Converting 1.3.x or older apps

Converting an older 1.3 app to the new 1.4 standard is quite easy

Create a new folder with the name (AppName) of the app and move the php file AppNameSetup.php to that folder. Also make sure you create a logo. (Name can be set in AppNameSetup.php) in this folder 

Replace ```namespace Hestia\WebApp\Installers;``` with ```namespace Hestia\WebApp\Installers\MyApp;```

And add following line below namespace Hestia\WebApp\Installers\MyApp;

```use \Hestia\WebApp\Installers\BaseSetup as BaseSetup;```

Then add the follow info to the class 

```
protected $appInfo = [ 
    'name' => 'Example',
    'group' => 'cms',
    'enabled' => true,
    'version' => 'latest',
    'thumbnail' => 'example.png' //Max size is 300px by 300px 
];
```

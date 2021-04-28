# Base php class for creating an Quick Install App for Hestia CP 1.4 and newer

In Hestia CP 1.4 we have decided to improve the Quick installer "App" to enable more flexibility in the near feature. 
With the new system users can simply upload a folder into /usr/local/hestia/web/src/app/WebApp/Installers/ and if the folder (AppName) contains a file name AppNameSetup.php it will add to the available apps list. 

## Creating new apps



## Converting 1.3.x or older apps

Converting an older 1.3 app to the new 1.4 standard is quite easy

Create a new folder with the name (AppName) of the app and move the php file AppNameSetup.php to that folder. Also make sure you create a logo. (Name can be set in AppNameSetup.php) in this folder 

Replace ```namespace Hestia\WebApp\Installers;``` with ```namespace Hestia\WebApp\Installers\MyApp;```

And add following line below namespace Hestia\WebApp\Installers\MyApp;

```use \Hestia\WebApp\Installers\BaseSetup as BaseSetup;```

Then add the follow info to the class 

    protected $appInfo = [ 
        'name' => 'Example',
        'group' => 'cms',
        'enabled' => true,
        'version' => 'latest',
        'thumbnail' => 'example.png' //Max size is 300px by 300px 
    ];

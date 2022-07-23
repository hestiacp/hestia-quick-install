<?php

namespace Hestia\WebApp\Installers\Example;

use Hestia\System\Util;
use \Hestia\WebApp\Installers\BaseSetup as BaseSetup;

class ExampleSetup extends BaseSetup {

    protected $appInfo = [ 
        'name' => 'Example',
        'group' => 'cms',
        //keep always set to enabled. When PHP version isn't supported it will change it to no and disable it
        'enabled' => true,
        'version' => 'latest',
        'thumbnail' => 'example.png' //Max size is 300px by 300px 
    ];
    
    protected $appname = 'example';
    protected $config = [
        'form' => [
            //Note at least one input field is currently required
            'protocol' => [ 
                'type' => 'select',
                //type in this case dropdown / select
                'options' => ['http','https'],
                //default options
                'value' => 'https'
                //value for default value 
            ],
            'site_name' => ['type'=>'text', 'value'=>'Demo'],
            'username' => ['value'=>'Username'],
            'email' => 'text',
            'password' => 'password',
            ],
        'database' => true, // add the text fields for Database Name, Database User, Database Password + the option to create them
        'resources' => [
            //resoruce may be an archive (zip, tar.gz)
            'archive'  => [ 'src' => 'https://download.example.com/example.version.tar.gz' ],
            //or a composer project for example.
            //By default composer v2 is used if you need to use v1 you can append 'version' => 1 to the composer array 
            'composer' => [ 'src' => 'example/projext', 'dst' => '/', 'version' => 1 ],
            # even src is set it will download wordpress via wp-cli. Currently only downloading is done over cli. Setting up is still done with curl. 
            'wp'  => [ 'src' => 'https://wordpress.org/latest.tar.gz' ],
        ], 
        'server' => [
            'nginx' => [
                'template' => 'wordpress',
            ],
            'apache2' => [
                'template' => 'example',
            ],
            'php' => [
                //list of supported php versions if available it will always select the last version
                //When non is available it will disable the "Quick install app" in the view
                'supported' => [ '7.4','8.0','8.1' ],
            ],
        ],
    ];
    
    public function install(array $options = null)
    {
        //parent::install will install the the resource on in /home/{user}/web/{domain}/public_html
        //Currenly only archive and composer project and wp-cli is supported. 
        parent::install($options);
        /*  
            Some can config need to be manipulated with config files
            v-open-fs-file
            v-move-fs-file
            v-delete-fs-file
            and so on. Please check /web/local/hesita/web/src/app/WebApp/Installers for more examples or use our documentation found on https://docs.hestiacp.com
            v-run-cli-cmd  has an limited list of allowed commands see https://github.com/hestiacp/hestiacp/blob/main/bin/v-run-cli-cmd
            
            Run here the other commands 
            Software that is installable via CLI command the easist way is use a an command like
            for example:
        */ 
        $this->appcontext->runUser('v-run-cli-cmd', ['/usr/bin/php',
            $this->getDocRoot('command/to/run'), 
            'maintenance:install',
            '--database mysql',
            '--database-name '.$this->appcontext->user() . '_' .$options['database_name'],
            '--database-user '.$this->appcontext->user() . '_' .$options['database_user'],
            '--database-pass '.$options['database_password'],
            '--admin-user '.$options['username'],
            '--admin-pass '.$options['password']
            ], $status);
            // If $status->code === 0 the command was executed properly / successfully 
            return ($status === 0);

    }
}
// When done upload the folder to /usr/local/hestia/web/src/app/WebApp/Installers

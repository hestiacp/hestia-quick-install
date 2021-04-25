<?php

namespace Hestia\WebApp\Installers\Example;

use Hestia\System\Util;
use \Hestia\WebApp\Installers\BaseSetup as BaseSetup;

class ExampleSetup extends BaseSetup {

    protected $appInfo = [ 
        'name' => 'Example',
        'group' => 'cms',
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
                'options' => ['http','https'],
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
            //or an composer project for example.
            'composer' => [ 'src' => 'example/projext', 'dst' => '/' ]
        ], 
    ];
    
    public function install(array $options = null)
    {
        //parent::install will install the the resource on in /home/{user}/web/{domain}/public_html
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
// When done upload the folder to /web/local/hesita/web/src/app/WebApp/Installers
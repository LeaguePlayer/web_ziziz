<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'ZIZIZ.RU',
    //localization
    'sourceLanguage'=>'ru',
    'language' => 'ru',
    'defaultController' => 'site',
  // preloading 'log' component
  'preload'=>array('log'),
  // autoloading model and component classes
  'import'=>array(
    'application.models.*',
    'application.components.*',
        'application.components.yiidebugtb-master.*',
        //'application.modules.user.models.*',
        //'application.modules.user.components.*',
  ),

  'modules'=>array(
    
    'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'gh0d0lybr',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1'),
    ),
  ),
  // application components
  'components'=>array(
    'user'=>array(
            'class' => 'WebUser',
      // enable cookie-based authentication
      'allowAutoLogin'=>true,
            'loginUrl' => array('/site/authenticate'),
    ),
        'phpThumb'=>array(
            'class'=>'ext.EPhpThumb.EPhpThumb',
            'options'=>array()
        ),
    // uncomment the following to enable URLs in path-format
    ///*
    'urlManager'=>array(
      'urlFormat'=>'path',
            'showScriptName' => false,
      'rules'=>array(
                'gii'=>'gii',
                'announcements/index/<gorod>'=>'announcements/index',
                'auto/index/<gorod>'=>'auto/index',
                //'auto/renderModelByBrendId<brend_id>'=>'auto/renderModelByBrendId',
                'auto/update/<id>'=>'auto/update',
                'announcements/update/<id>'=>'announcements/update',
                'announcements/<gorod>/<id>'=>'announcements/view',
                'auto/<gorod>/<id>'=>'auto/view',
                '<controller>'=>'<controller>/index',
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
      ),
    ),
        'session' => array(
            'sessionName'=>'ZIZIZ_SESSION',
            'class'=>'CHttpSession',
            'autoStart'=>false,
            'cookieMode'=>'only',
        ),
        //*/
    
        // uncomment the following to use a MySQL database
    /*
    'db'=>array(
      'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    ),
         
    */
    'db'=>array(
      'connectionString' => 'mysql:host=localhost;dbname=xxx',
      'emulatePrepare' => true,
      'username' => 'xxx',
      'password' => 'xxx',
      'charset' => 'utf8',
    ),
    'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
    'errorHandler'=>array(
      // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        
    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning, trace, info',
        ),
                array( // configuration for the toolbar
                    'class'=>'XWebDebugRouter',
                    'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                    'levels'=>'error, warning, trace, profile, info',
                    'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
                ),
        // uncomment the following to show log messages on web pages
        /*
        array(
          'class'=>'CWebLogRoute',
                    //'levels'=>'trace',
                    //'showInFireBug'=>true,
        ),
        */
      ),
    ),
        /*
        'cache'=>array(
            'class'=>'system.caching.CMemCache',
        ),
        */
  ),
  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params'=>array(
    // this is used in contact page
    //'adminEmail'=>'webmaster@example.com',
        'salt'=>'ds1FGoghg12_!,..?//',
        'news_folder'=>'/uploads/news/',
        'domain'=>'http://ziziz.loc',
        'def_city_id'=>5,
        'def_city_name'=>'Тюмень',
        'admin_email'=>'support@ziziz.ru',
        'norepeat_email'=>'no-repeat@ziziz.ru',
        'support_phone'=>'',
        'support_email'=>'support@mail.ru'
  ),
);
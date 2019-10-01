<?php
// Define path to document root
defined('DOCUMENTROOT_PATH')
|| define('DOCUMENTROOT_PATH', dirname(__FILE__, 3));

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', DOCUMENTROOT_PATH.'/zf/application');

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, [
    realpath(APPLICATION_PATH.'/../library'),
    get_include_path(),
]));

/** Zend_Config_Ini */
require_once 'Zend/Config/Ini.php';

$config = new Zend_Config_Ini(
    APPLICATION_PATH . '/configs/application.ini',
    APPLICATION_ENV,
    ['allowModifications' => true]);
$common = new Zend_Config_Ini(
    APPLICATION_PATH . '/configs/config.ini',
    APPLICATION_ENV,
    ['allowModifications' => true]
);
$config->merge($common);

/** Zend_Registry */
require_once 'Zend/Registry.php';
Zend_Registry::set('config', $config);

require_once realpath(APPLICATION_PATH . '/../../vendor/autoload.php');

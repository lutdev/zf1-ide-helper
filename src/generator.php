<?php
//require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/config.php';

/** Zend_Application */
require_once 'Zend/Application.php';
// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, $config);

$bootstrap = new Bootstrap($application);
$bootstrap->bootstrap();

$helpersDir = realpath('zf/application/views/helpers');
$files = scandir($helpersDir);

$output = "<?php\n
interface Zend_View_Interface\n{\n\n";

foreach ($files as $fileName) {
    if (strpos($fileName, '.php') === false) {
        continue;
    }
    $fileNameWithoutExtension = str_replace('.php', '', $fileName);

    $className = 'View_Helper_'.$fileNameWithoutExtension;
    $classInfo = new ReflectionClass($className);

    $output .= "    /** @return ".$className." */\n    public function ".lcfirst($fileNameWithoutExtension)."();\n\n";
}

$output .= "}\n";

$ideFile = DOCUMENTROOT_PATH.'/.ide_helper.php';
file_put_contents($ideFile, $output);

<?php
declare(strict_types=1);

use sf\phpmvc\controller\ResponseController;
use sf\phpmvc\helper\AbstractTool;

define('ROOT_PATH', dirname(__DIR__));
chdir(ROOT_PATH);

set_error_handler(
    function (int $_severity, string $_message, string $_file, int $_line): void {
        throw new ErrorException($_message, 0, $_severity, $_file, $_line);
    }
);

$vendorPath = ROOT_PATH.'/vendor/autoload.php';

if (!file_exists($vendorPath)) {
    exec('sh ./bin/install.sh');
}

require_once $vendorPath;

AbstractTool::loadConfig(ROOT_PATH.'/config/backend.json');

$response = new ResponseController();
$response->run();
echo $response->response();
exit;
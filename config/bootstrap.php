<?php
declare(strict_types=1);
require __DIR__ . '/paths.php';
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ConsoleErrorHandler;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Router;
use Cake\Utility\Security;

try {
	Configure::config('default', new PhpConfig());
	Configure::load('app', 'default', false);
} catch (\Exception $e) {
	exit($e->getMessage() . "\n");
}

if (file_exists(CONFIG . 'app_local.php')) {
	Configure::load('app_local', 'default');
}

if (Configure::read('debug')) {
	Configure::write('Cache._cake_model_.duration', '+2 minutes');
	Configure::write('Cache._cake_core_.duration', '+2 minutes');
	// disable router cache during development
	Configure::write('Cache._cake_routes_.duration', '+2 seconds');
}

date_default_timezone_set(Configure::read('App.defaultTimezone'));
mb_internal_encoding(Configure::read('App.encoding'));
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
	(new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
	(new ErrorHandler(Configure::read('Error')))->register();
}

if ($isCli) {
	require __DIR__ . '/bootstrap_cli.php';
}

$fullBaseUrl = Configure::read('App.fullBaseUrl');
if (!$fullBaseUrl) {
	$s = null;
	if (env('HTTPS')) {
		$s = 's';
	}

	$httpHost = env('HTTP_HOST');
	if (isset($httpHost)) {
		$fullBaseUrl = 'http' . $s . '://' . $httpHost;
	}
	unset($httpHost, $s);
}
if ($fullBaseUrl) {
	Router::fullBaseUrl($fullBaseUrl);
}
unset($fullBaseUrl);

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Mailer::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

ServerRequest::addDetector('mobile', function ($request) {
	$detector = new \Detection\MobileDetect();

	return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
	$detector = new \Detection\MobileDetect();

	return $detector->isTablet();
});

define('DIR_PROPERTIES', WWW_ROOT.'properties');
define('DIR_TEMPLATE', WWW_TEMPLATE.'Applications');
define('DIR_LAYOUT', WWW_TEMPLATE.'layout');
define('DIR_ELEMENT', WWW_TEMPLATE.'element');
define('DIR_COMPONENT', WWW_TEMPLATE.'element/component');
define('DIR_UPLOAD', WWW_ROOT.'assets');
define('FILE_AUTHORIZATION', 'authorization.json');
define('FILE_TOKEN', 'token.json');
define('FILE_LAYOUT', 'layout.json');
define('FILE_APP', 'app.php');
define('FILE_DEFAULT', 'default.php');
define('FILE_MENU', 'menu.php');

// Define Message Area
//Define Message Area
define('MESSAGE_REQUIRED', ' is required.');
define('MESSAGE_SUCCESS', ' is success.');
define('IMAGE_EXTENTION', ['gif', 'png', 'jpg', 'jpeg']);
define('MESSAGE_INVALIDE_FILE', 'Your file is not allowed.');
define('MESSAGE_INVALIDE_SECRET_KEY', 'Invalid secret key.');
define('MESSAGE_INVALIDE_DIR', 'Invalid Directory name (musted start with back slash)');
define('MESSAGE_INVALIDE_DIRECTTORY', 'Your file is not allowed to upload here.');
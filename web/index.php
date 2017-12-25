<?php
ini_set('display_errors', false);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/constants.php';
require_once __DIR__.'/../config/database.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Reference;
use QuickBetOnline\Application\Listeners\StringResponseListener;
use QuickBetOnline\Application\Listeners\ResponseListener;
use QuickBetOnline\Application\Listeners\ControllerListener;

$sc = \QuickBetOnline\Application\Container::GetInstance()->getContainer();

$request = Request::createFromGlobals();

$sc->register('listener.string_response', StringResponseListener::class);
$sc->register('listener.add_arguments_controller', ControllerListener::class);

$capsule = $sc->get('capsule');
$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
));

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();

//set controller listeners
$sc->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', array(new Reference('listener.string_response')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.add_arguments_controller')));

$sc->setParameter('charset', 'UTF-8');
$sc->setParameter('routes', require_once __DIR__.'/../app/routes.php');
$sc->setParameter('views', \Config::VIEWS_ROOT);
$sc->setParameter('twig_cache', \Config::TWIG_CACHE_ROOT);
$sc->setParameter('twig_debug', false);

$sc->setParameter('exceptionHandler', 'QuickBetOnline\Controllers\ErrorController::exceptionAction');

$response = $sc->get('app')->handle($request);

$response->send();
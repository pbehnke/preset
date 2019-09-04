<?php

use Awurth\Slim\Helper\Twig\AssetExtension;
use Awurth\Slim\Helper\Twig\CsrfExtension;
use Awurth\SlimValidation\Validator;
use Awurth\SlimValidation\ValidatorExtension;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extension\DebugExtension;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use App\TwigExtensions\Translate;

$capsule = new Manager();
$capsule->addConnection($container['settings']['eloquent']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['flash'] = function () {
    return new Messages();
};

$container['csrf'] = function ($container) {
    $guard = new Guard();
    $guard->setFailureCallable($container['csrfFailureHandler']);

    return $guard;
};

// https://github.com/awurth/SlimValidation
$container['validator'] = function () {
    return new Validator();
};

$container['twig'] = function ($container) {

    $request = $container['request'];

    $config = $container['settings']['twig'];

    $twig = new Twig($config['path'], $config['options']);

    $twig->addExtension(new Translate($container['translator']));
    $twig->addExtension(new TwigExtension($container['router'], $request->getUri()));
    $twig->addExtension(new DebugExtension());
    $twig->addExtension(new AssetExtension($request));
    $twig->addExtension(new CsrfExtension($container['csrf']));
    $twig->addExtension(new ValidatorExtension($container['validator']));

    $twigEnviroment = $twig->getEnvironment();
    $twigEnviroment->addGlobal('flash', $container['flash']);
    $twigEnviroment->addGlobal('auth', $container['auth']);
    $twigEnviroment->addGlobal('settings', $container['settings']);
    $twigEnviroment->addGlobal('path', basename($request->getUri()));
    $twigEnviroment->addGlobal('cookies',  $container['cookies']);

    $auth = $container['auth'];
    if ($auth->check()) {
      $twigEnviroment->addGlobal('projects', $auth->getUser()->projects()->get());
      $twigEnviroment->addGlobal('messages', $auth->getUser()->messages()->get());
    }

    $twigEnviroment->addGlobal('version', shell_exec('svnversion > version.php'));

    return $twig;
};

$container['cookies'] = function($container) {

  $request = $container['request'];

  $projectsList = $request->getCookieParam('projects.list');
  if (strlen($projectsList) === 0) {
    $projectsList = 'cards';
  }

  return [
      'sidebar' => [
        'toggled' => $request->getCookieParam('main.sidebar.toggled')
      ],
      'projects' => [
        'list' => $projectsList
      ]
  ];
};

$container['translator'] = function ($container) {
    $loader = new FileLoader(new Filesystem(), __DIR__ . '/lang');
    return new Translator($loader, $container['settings']['locale']);
};

$container['auth'] = function ($container) {
    $sentinel = new Sentinel(new SentinelBootstrapper($container['settings']['sentinel']));
    return $sentinel->getSentinel();
};

$container['monolog'] = function ($container) {
    $config = $container['settings']['monolog'];

    $logger = new Logger($config['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($config['path'], $config['level']));

    return $logger;
};

<?php

$app->get('/', 'controller.app:home')->setName('home');
$app->get('/logout', 'controller.auth:logout')->setName('logout');

$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'controller.auth:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'controller.auth:register')->setName('register');
    $this->map(['GET', 'POST'], '/forgot', 'controller.auth:forgot')->setName('forgot');
})->add($container['middleware.guest']);

$app->group('', function () {
  $this->post('/profile', 'controller.auth:profile')->setName('profile');
  $this->map(['GET', 'POST'], '/messages', 'controller.auth:messages')->setName('messages');
  $this->map(['GET', 'POST'], '/alerts', 'controller.auth:alerts')->setName('alerts');
})->add($container['middleware.auth']);

$app->group('/settings/{template}', function () {
  $this->get('', 'controller.app:settings')->setName('settings');
})->add($container['middleware.auth']());

$app->group('/users/{userid}/projects', function () {
    $this->get('', 'controller.projects:list')->setName('projects');
    $this->put('', 'controller.projects:add')->setName('projectsAdd');
    $this->post('/{projectid}', 'controller.projects:edit')->setName('projectEdit');
    $this->delete('/{projectid}', 'controller.projects:delete')->setName('projectDelete');
    $this->get('/{projectid}/editor', 'controller.projects:editor')->setName('projectEditor');
    $this->post('/{projectid}/publish', 'controller.projects:publish')->setName('projectPublish');
})->add($container['middleware.auth']());

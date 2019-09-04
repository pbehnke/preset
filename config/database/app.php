<?php
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

//projects
Manager::schema()->create('projects', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id');
    $table->string('name');
    $table->string('title');
    $table->string('description');
    $table->string('url');
    $table->string('template');
    $table->integer('completion');
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('users');
});

//alerts
Manager::schema()->create('alerts', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id');
    $table->integer('status_id');
    $table->string('title');
    $table->string('description');
    $table->integer('priority');
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('users');
});

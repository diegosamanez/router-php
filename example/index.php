<?php

use agregalel\router_php\Route;
use controllers\TestController;

include __DIR__ . "/../vendor/autoload.php";
include __DIR__ . "/controllers/TestController.php";

Route::get('', [new TestController(), 'index']);

Route::get('param_request_example/{:id}', [new TestController(), 'paramRequestExample']);

Route::get('form_example', [new TestController(), 'formExample']);

Route::post('post_example', [new TestController(), 'postExample']);

Route::get('404', [new TestController(), 'error']);

/**
 * Init Router
 */
Route::initRouter();
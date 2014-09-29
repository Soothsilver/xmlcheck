<?php

use asm\core\Config,
    asm\core\Core,
    asm\utils\ErrorHandler,
	asm\core\UiResponse,
    asm\core\Error;


/**
 * @file
 * Handles core requests coming from UI.
 *
 * Attempts following actions:
 * @li turn on class autoloading using Autoload from folders set in application config
 * @li turn on error handling using ErrorHandler and logging of all uncaught exceptions
 * @li turn on sending of 'runtime error' responses in case of uncaught exception
 * @li call core request handler with $_POST data as arguments (or $_GET if $_POST is empty)
 *
 */

// Session is used to keep tract of user login and perhaps something else? TODO
session_start();

// Load up the Composer-generated autoloader. All PHP classes are loaded using this autoloader.
require_once(__DIR__ . "/../vendor/autoload.php");

// Load configuration from the "config.ini" file.
Config::init(__DIR__ . '/config.ini', __DIR__ . '/internal.ini');

// If ever an exception occurs or a PHP error occurs, log it and send it to the user.
ErrorHandler::register();
ErrorHandler::bind(array('asm\core\Core', 'logException'));
ErrorHandler::bind(function (Exception $e) {
	Core::sendUiResponse(UiResponse::create(array(), array(
			Error::create(Error::levelFatal, $e->getMessage(), \asm\core\lang\Language::get(\asm\core\lang\StringID::ServerSideRuntimeError)))));
});

// Process the AJAX request.
Core::handleUiRequest(empty($_POST) ? $_GET : $_POST, $_FILES);

<?php

namespace wrun;


require_once("./runner.php");
require_once("./request.php");
require_once("./response.php");

$funbase = $_ENV["WRUN_BASE"] ?? ($_SERVER['DOCUMENT_ROOT'] . '/../server-functions');
$request_path = runner::get_function($_SERVER);

// print "request_path: $request_path ~ $basepath ~ " . PHP_SAPI;
// print_r($_SERVER);
// exit;
$runner = new runner($funbase);
$runner->run($request_path);

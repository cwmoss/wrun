<?php

namespace wrun;

function dbg($txt, ...$vars) {
    // im servermodus wird der zeitstempel automatisch gesetzt
    //	$log = [date('Y-m-d H:i:s')];
    $log = [];
    if (!is_string($txt)) {
        array_unshift($vars, $txt);
    } else {
        $log[] = $txt;
    }
    $log[] = join(' ~ ', array_map(fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $vars));
    error_log(join(' ', $log));
}

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

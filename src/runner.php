<?php

namespace wrun;

/*
    must be php 7.4 compatible (for now)
*/

class runner {

    public string $base;
    public array $env = [];

    public function __construct(string $base) {
        $this->base = $base;
        $this->load_env();
    }

    public function run($url) {
        $req = new request($url, $this->env);
        $resp = new response();
        $cname = $req->method . "_" . $req->name;
        $file = $this->base . "/$cname" . ".php";
        if (file_exists($file)) {
            include($file);
            $handler = new $cname;
            $resp = $handler($req, $resp);
        } else {
            $resp->not_found();
        }
        $resp->emit();
    }

    public static function get_function(array $server) {
        $prefix = dirname($server["SCRIPT_NAME"]);
        $prefix = ltrim($prefix, "./");
        $prefix = "/" . $prefix;
        $fun = preg_replace("~^{$prefix}~", "", $server["REQUEST_URI"]);
        return ltrim($fun, "/");
    }

    public function load_env() {
        $env = [];
        if (file_exists("{$this->base}/.env")) {
            foreach (file("{$this->base}/.env") as $line) {
                $line = trim($line);
                if (!$line || $line[0] == "#") continue;
                $key_value = explode("=", $line) + [1 => null];
                if ($key_value[1] === null) continue;
                $key_value = array_map('trim', $key_value);
                if ($key_value[1][0] == "'") $key_value[1] = trim($key_value[1], "'");
                if ($key_value[1][0] == '"') $key_value[1] = trim($key_value[1], '"');
                $env[$key_value[0]] = $key_value[1];
            }
        }
        $this->env = ($_ENV ?? []) + $env;
    }
}

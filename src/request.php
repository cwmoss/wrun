<?php

namespace wrun;

class request {
    public $name;
    public $method;
    public $get;
    public $post;
    public $env = [];
    public array $body = [];

    public function __construct($url, $env = []) {
        $this->name = $url;
        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
        $this->get = $_GET;
        $this->post = $_POST;
        $this->env = $env;
        $body = file_get_contents('php://input');
        if ($body) $this->body = json_decode($body, true);
    }
}

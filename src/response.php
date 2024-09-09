<?php

namespace wrun;

class response {

    public string $status = "200";
    public string $content_type = "application/json";
    public array $body = [];

    public function __construct() {
    }

    public function body(array $data) {
        $this->body = $data;
        return $this;
    }

    public function not_found() {
        $this->status = "404";
        $this->body = ["res" => "fail"];
        return $this;
    }

    public function fail() {
        $this->status = "500";
        $this->body = ["res" => "fail"];
        return $this;
    }

    public function emit() {
        header('HTTP/1.1 ' . $this->status);
        header("Content-Type: {$this->content_type}");
        print json_encode($this->body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

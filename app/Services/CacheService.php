<?php
namespace App\Services;

class CacheService {
    private $path;
    private $namespace;

    public function __construct(string $namespace, string $cachedir) {
        $this->path = $cachedir.'/_'.$namespace;
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        } 
        $this->namespace = $namespace;
    }

    public function set(string $key, string $value, int $expires = null) {
        $data = [
            'expires' => $expires,
            'value' => $value
        ];
        file_put_contents($this->path.'/'.$key, json_encode($data));
    }

    public function 
}
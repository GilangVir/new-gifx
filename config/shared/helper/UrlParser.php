<?php
namespace App\Shared;

class UrlParser {

    public static function urlToPath(array $data = [], string $default = "index") {
        if(empty($data)) {
            return $default;
        }

        if(count($data) < 2) {
            $data[] = "index";
        }

        foreach($data as $key => $val) {
            $data[$key] = filter_var(strtolower($val), FILTER_SANITIZE_URL);
        }

        return implode("/", $data);
    }
}
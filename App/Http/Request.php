<?php

namespace App\Http;

/**
 * @author  Joseph Abah
 *
 * Class Request -- handle simple http request
 *
 * @package \App\Http
 */
class Request
{
    private static $instance;


    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (!static::$instance) {
            static::$instance = new self();

        }
        return static::$instance;
    }

    public function mapParams(array $params)
    {

        foreach ($params as $p) {

            $this->{$p['variable']} = $p['data'];
        }
    }

    public function inputs()
    {
        return array_merge($_GET, $_POST);
    }

    public function input($key)
    {
        $inputs = $this->inputs();
        return $inputs[$key] ?? ''; //TODO: Add some clean up here
    }

    public function files()
    {
        return $_FILES;
    }


}

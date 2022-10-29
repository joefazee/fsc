<?php

namespace App\Http;

/**
 * @author  Joseph Abah
 *
 * Class Response - handle simple http response
 * I use this form to also render template
 *
 * @package \App\Http
 */
class Response
{
    public function send($content): void
    {
        echo $content;
    }

    /**
     * @throws \JsonException
     */
    public function sendJson(array $content): void
    {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_THROW_ON_ERROR);
        exit;
    }

    /**
     * Render html
     * TODO: Make template path configurable
     *
     * @param string $templatePath
     * @param array  $data
     * @param bool   $render
     *
     * @return string|null
     */
    public function render(string $templatePath, array $data = [], bool $render = true): ?string
    {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        $fullPath = APP_PATH . '/templates/' . $templatePath . '.php';
        require_once $fullPath;
        $content = ob_get_contents();
        ob_clean();

        if ($render) {
            echo $content;
        }

        return $content;
    }


    public function redirect($to): void
    {
        header('Location: ' . $to);
        exit;
    }
}

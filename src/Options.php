<?php

namespace SimpleRequest;

use Exception;

class Options
{
    public ?string $url = null;

    /** @var string "GET"|"HEAD"|"POST"|"PUT"|"PATCH"|"DELETE" */
    public string $method = 'GET';
    public array $query = [];
    public array $body = [];
    public array $headers = [];
    public bool $json = true;

    public static function build(string $method, string $url, array $query, array $headers)
    {
        $options = new Options();
        $options->method = $method;
        $options->url = $url;
        $options->query = $query;
        $options->headers = $headers;
        $options->checkOptions();
        return $options;
    }

    public static function buildWithBody(string $method, string $url, array $query, array $body, array $headers, bool $json = true)
    {
        $options = new Options();
        $options->method = $method;
        $options->url = $url;
        $options->query = $query;
        $options->headers = $headers;
        $options->body = $body;
        $options->json = $json;
        $options->checkOptions();
        return $options;
    }

    /**
     * @throws Exception
     */
    public function checkOptions(): void
    {
        $supportMethods = [
            'GET',
            'HEAD',
            'POST',
            'PUT',
            'PATCH',
            'DELETE'
        ];

        if (is_null($this->url)) {
            throw new Exception("Url is Empty");
        }

        if (!(str_starts_with($this->url, "http://") || str_starts_with($this->url, "https://"))) {
            throw new Exception("Url must begin with http:// or https://");
        }

        if (!in_array($this->method, $supportMethods)) {
            throw new Exception("HTTP Method Error,Support GET,HEAD,POST,PUT,PATCH,DELETE");
        }
    }

    public function parseHeaders(): array
    {
        $headers = [];
        foreach ($this->headers as $key => $value) {
            $headers[] = "$key:$value";
        }
        return $headers;
    }

    public function parseBody(): string
    {
        if ($this->json) {
            $body = json_encode($this->body);
        } else {
            $body = http_build_query($this->body);
        }
        return $body;
    }
}
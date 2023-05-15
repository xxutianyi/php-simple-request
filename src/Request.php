<?php
/*
 * Copyright (c) XuTianyi 2023.
 * Email: xutianyi12@outlook.com.
 * Github: https://github.com/xxutianyi
 */

namespace SimpleRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Request
{


    /**
     * @param string $url
     * @param array|string $query
     * @param array $headers
     * @return string
     * @throws GuzzleException
     */
    public static function get(string $url, array|string $query = [], array $headers = []): string
    {
        $client = new Client();
        return $client->get(
            $url,
            [
                'headers' => $headers,
                'query' => $query,
            ]
        )->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array|string $query
     * @param array $params
     * @param array $form
     * @param array $headers
     * @return string
     * @throws GuzzleException
     */
    public static function post(string $url, array|string $query = [], array $params = [], array $form = [], array $headers = []): string
    {
        $client = new Client();
        return $client->post(
            $url,
            [
                'headers' => $headers,
                'query' => $query,
                'json' => $params,
                'multipart' => $form,
            ]
        )->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array|string $query
     * @param array $params
     * @param array $headers
     * @return string
     * @throws GuzzleException
     */
    public static function put(string $url, array|string $query = [], array $params = [], array $headers = []): string
    {
        $client = new Client();
        return $client->put(
            $url,
            [
                'headers' => $headers,
                'query' => $query,
                'json' => $params,
            ]
        )->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array|string $query
     * @param array $headers
     * @return string
     * @throws GuzzleException
     */
    public static function delete(string $url, array|string $query = [], array $headers = []): string
    {
        $client = new Client();
        return $client->delete(
            $url,
            [
                'headers' => $headers,
                'query' => $query,
            ]
        )->getBody()->getContents();
    }
}

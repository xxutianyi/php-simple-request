<?php

namespace SimpleRequest;

use Exception;
use SimpleRequest\Exceptions\ClientException;
use SimpleRequest\Exceptions\ServerException;
use SimpleRequest\Exceptions\TimeoutException;

class Request
{
    /**
     * @throws ServerException
     * @throws ClientException
     * @throws Exception
     */
    public static function get(string $url, array $query = [], array $headers = [])
    {
        return self::request(Options::build("GET", $url, $query, $headers));
    }

    /**
     * @throws ServerException
     * @throws ClientException
     * @throws Exception
     */
    public static function post(string $url, array $query = [], array $body = [], array $headers = [], bool $json = true)
    {
        return self::request(Options::buildWithBody("POST", $url, $query, $body, $headers, $json));
    }

    /**
     * @throws ServerException
     * @throws ClientException
     * @throws Exception
     */
    public static function put(string $url, array $query = [], array $body = [], array $headers = [], bool $json = true)
    {
        return self::request(Options::buildWithBody("PUT", $url, $query, $body, $headers, $json));
    }

    /**
     * @throws ServerException
     * @throws ClientException
     * @throws Exception
     */
    public static function delete(string $url, array $query = [], array $headers = [])
    {
        return self::request(Options::build("DELETE", $url, $query, $headers));
    }

    /**
     * @throws ServerException
     * @throws ClientException
     * @throws Exception
     */
    public static function request(Options $options)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $options->url . "?" . http_build_query($options->query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 3000);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 30000);

        if ($options->json) {
            $headers = [
                ...$options->parseHeaders(),
                "Content-type: application/json",
            ];
        } else {
            $headers = [
                ...$options->parseHeaders(),
                "Content-type: application/x-www-form-urlencoded",
            ];
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        switch ($options->method) {
            case "POST":
                curl_setopt($ch, CURLOPT_POSTFIELDS, $options->parseBody());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_POSTFIELDS, $options->parseBody());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                break;
        }

        $response = curl_exec($ch);

        if (curl_errno($ch) === 0) {
            $info = curl_getinfo($ch);
            $success = !empty($info['http_code']) && ($info['http_code'] == 200 || $info['http_code'] == 201);

            if ($success) {
                $res = json_decode($response);
                if (json_last_error() == JSON_ERROR_NONE) {
                    $return = $res;
                } else {
                    $return = $response;
                }
            } else {
                $isClientError = !empty($info['http_code']) && $info['http_code'] >= 400 && $info['http_code'] < 500;
                $isServerError = !empty($info['http_code']) && $info['http_code'] >= 500;
                if ($isClientError) {
                    throw new ClientException($info['http_code'], $response);
                } elseif ($isServerError) {
                    throw new ServerException($info['http_code'], $response);
                } else {
                    throw new Exception("Response Code {$info['http_code']}: $response");
                }
            }
            curl_close($ch);
            return $return;
        } else {

            $code = curl_errno($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($code == CURLE_OPERATION_TIMEOUTED) {
                throw new TimeoutException($error);
            }

            throw new Exception("CURL Error, Code: $code ,Message: $error");
        }
    }
}
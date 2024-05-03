<?php

namespace App\Lib;

use App\Lib\dummies\UserDao;

class BetterStackService
{
    public static function pluck($array, $key): array
    {
        return array_map(function ($item) use ($key) {
            return $item[$key];
        }, $array);
    }


    // Function to extract discussion tags from text
    private static function extractTags($text): array {
        preg_match_all('/\b[A-Z][a-z]+\b/', $text, $matches);
        return $matches[0];
    }

    // Function to send HTTP request
    private static function sendRequest($url, $method, $data = null, $headers = []): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['body' => $response, 'code' => $statusCode];
    }
}

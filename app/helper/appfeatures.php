<?php
use Illuminate\Support\Facades\Http;
if (!function_exists('appFeatures')) {
    function appFeatures()
    {
        $url = "http://localhost/noor/api/project-features";
        $response = Http::get($url);
        $data = json_decode($response->body(), true);
        return $data;
    }
}

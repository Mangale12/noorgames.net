<?php
use Illuminate\Support\Facades\Http;
if (!function_exists('appFeatures')) {
    function appFeatures()
    {
        $url = "https://portal.caandv.com/api/project-features";
        $response = Http::get($url);
        $data = json_decode($response->body(), true);
        return $data;
    }
}

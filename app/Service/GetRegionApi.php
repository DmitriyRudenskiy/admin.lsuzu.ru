<?php
namespace App\Service;


class GetRegionApi
{
    public function get($number)
    {
        $data = [
            "q" => "7" . substr($number, -10),
            "key" => env("KODY_KEY")
        ];

        $url = env("KODY_URL") . "?" . http_build_query($data);

        try {
            $content = file_get_contents($url);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $json = json_decode($content);

        if (empty($json->numbers[0]->region)) {
            return '-- ошибка --';
        }

        return $json->numbers[0]->region;
    }
}

<?php
namespace App\Service\Crm;

use InvalidArgumentException;

class Client
{
    private $url;

    private $debug = false;

    public function __construct()
    {
        if (empty(env('API_TOKEN'))) {
            throw new InvalidArgumentException();
        }

        $this->url = sprintf("http://0.0.0.0:9501/api/v3/%s/parts/phone", env('TOKEN_ENV'));
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function getRequest($data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        // Инициируем запрос к API и сохраняем ответ в переменную
        $out = curl_exec($curl);

        // Получим HTTP-код ответа сервера
        $code = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($this->debug) {
            echo sprintf("Code: %s\tresponse: %s\n", $code, $out);
        }

        // Завершаем сеанс cURL
        curl_close($curl);

        if ($code != 200 && $code != 204) {
            return null;
        }

        $content = json_decode($out);

        if ($content !== false) {
            return $content;
        }

        return null;
    }

    public function setDebug($status)
    {
        $this->debug = !empty($status);
    }
}
<?php
namespace App\Service\Sipuni;

use RuntimeException;

class Loader
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param Query $query
     * @return string
     */
    public function get(Query $query)
    {
        if (empty($this->url)) {
            throw new RuntimeException();
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query->getQuery());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}
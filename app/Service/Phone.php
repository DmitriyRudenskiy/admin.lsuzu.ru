<?php
namespace App\Service;


class Phone
{
    /**
     * @param string $text
     * @return null|string
     */
    public function parsing($text)
    {
        $phone = preg_replace('/[^0-9]/', '', $text);

        if (strlen($phone) == 10) {
            return $phone;
        }

        if (strlen($phone) == 11) {
            return substr($phone, -10);
        }

        return null;
    }

    /**
     * @param string $number
     * @return bool
     */
    public function isValid($number)
    {
        if (strlen($number) != 10 && strlen($number) != 11) {
            return false;
        }

        return true;
    }
}
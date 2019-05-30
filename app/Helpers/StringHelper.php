<?php
/**
 * Created by PhpStorm.
 * User: TrinhNV
 * Date: 4/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

class StringHelper
{
    /**
     * Generate and return a random characters string
     *
     * Useful for generating passwords or hashes.
     *
     * The default string returned is 10 alphanumeric characters string.
     *
     * The type of string returned can be changed with the "type" parameter.
     * Four types are: alpha, alphanum, num, nozero.
     *
     * @param   integer $length Length of the string to be generated, Default: 10 characters long.
     * @param   string  $type   Type of random string.  alpha, alphanum, num, nozero.
     *
     * @return  string
     */
    public function getRandomString($length = 10, $type = ALPHANUM)
    {
        $seedings = array();
        $seedings['alpha'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $seedings[ALPHANUM] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $seedings['num'] = '0123456789';
        $seedings['nozero'] = '123456789';
        if (!isset($seedings[$type])) {
            $type = ALPHANUM;
        }

        $pool = $seedings[$type];

        return $this->generateRandomString($pool, $length);
    }

    /**
     * @param $inputString
     * @param $length
     *
     * @return string
     */
    public function generateRandomString($inputString, $length)
    {
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($inputString, mt_rand(0, strlen($inputString) - 1), 1);
        }
        return $str;
    }

    /**
     * @param int $maxLength
     *
     * @return string
     */
    public function generateActivateToken($maxLength = 128)
    {
        $length = 0;
        $result = '';
        while ($length < $maxLength) {
            $buffLength = rand(20, 50);
            if ($length + $buffLength > $maxLength) {
                $buffLength = $maxLength - $length;
            }

            $result .= $this->getRandomString($buffLength) . '_';
            $length += $buffLength + 1;
        }

        return $result;
    }

    /**
     * @param $postalCode
     *
     * @return array|null
     */
    public function getAddressFromPostCode($postalCode)
    {
        $endpoint = 'https://madefor.github.io/postal-code-api/api/v1/';

        if (strpos($postalCode, '-') !== false) {
            $codeParts = explode('-', $postalCode);
            $fullEndpoint = $endpoint . $codeParts[0] . '/' . $codeParts[1] . '.json';
        } else {
            $prefixCode = substr($postalCode, 0, 3);
            $subfixCode = substr($postalCode, 3);
            $fullEndpoint = $endpoint . $prefixCode . '/' . $subfixCode . '.json';
        }

        $jsonAddr = @file_get_contents($fullEndpoint);
        if (is_null($jsonAddr) || strlen($jsonAddr) <= 0) {
            return NULL;
        }
        $arrAddress = json_decode($jsonAddr, true);
        if (!isset($arrAddress['data']) || count($arrAddress['data']) <= 0) {
            return NULL;
        }
        $addressData['pref_id'] = $arrAddress['data'][0]['prefcode'];
        return array_merge($addressData, $arrAddress['data'][0]['ja']);
    }

    /**
     * @param $inputString
     *
     * @return string
     */
    public static function removeWhiteSpace($inputString)
    {
        if ($inputString) {
            return preg_replace('/[ 　]/u', '', $inputString);
        }
        return $inputString;
    }

    /**
     * @param $inputString
     *
     * @return mixed
     */
    public static function getPhoneNumber($inputString)
    {
        if ($inputString) {
            return preg_replace('/[()-]+/', '', $inputString);
        }
        return $inputString;
    }

    /**
     * @param $word1
     * @param $word2
     * @param $str
     *
     * @return array
     */
    public static function doubleExplode($word1, $word2, $str)
    {
        $return = array();

        $array = explode($word1, $str);

        foreach ($array as $value) {
            $return = array_merge($return, explode($word2, $value));
        }
        return $return;
    }

    /**
     * @param $inputString
     *
     * @return string
     */
    public static function newLine2Break($inputString)
    {
        if (!$inputString) {
            return '';
        }
        return nl2br($inputString);
    }

}

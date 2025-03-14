<?php
namespace App\Libraries;

class IpayService
{
    private const KEY = 'kf@H%3HV3DbgKtW9SJCJDZwh6$%z8!G2';
    
    private const VID = 'bglobe';

    public static function generateData($data)
    {
        $fields = array(
            "live" => "1",
            "oid" => $data['oid'],
            "ttl" => $data['total'],
            "tel" => $data['phone'],
            "eml" => $data['email'],
            "vid" => self::VID,
            "curr" => $data['currency'],
            "cbk" => $data['url'],
            "cst" => "1",
            "crl" => "2"
        );
        $hash = hash_hmac('sha1', implode('', array_values($fields)), self::KEY);
        $fields['hsh'] = $hash;

        return $fields;
    }

    public static function getPayment($oid)
    {
        $url = 'https://apis.ipayafrica.com/payments/v2/transaction/search';
        $hash = hash_hmac('sha256', $oid.self::VID, self::KEY);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'oid' => $oid,
            'vid' => self::VID,
            'hash' => $hash
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $results = curl_exec($ch);
        curl_close($ch);

        return json_decode($results, true);
    }
}
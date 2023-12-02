<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Produk extends CI_Controller
{
    public function getDataAPI()
    {
        $username = 'tesprogrammer021223C14';
        $password = 'bisacoding-02-12-23';
        $client = new Client();

        $response = $client->request('POST', 'https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'form_params' => [
                'username' => $username,
                'password' => md5($password)
            ],
            'verify' => false,
        ]);

        $result = json_decode($response->getBody()->getContents(), TRUE);

        header("Content-Type: application/json");
        print_r(json_encode($result['data']));
        exit();
    }
}

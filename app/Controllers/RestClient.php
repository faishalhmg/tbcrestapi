<?php

namespace App\Controllers;

class RestClient extends BaseController
{
    public function index()
    {
        // $client = \Config\Services::curlrequest();
        // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
        // eyJlbWFpbCI6ImZhaXNoYWxobWdAeWFob28uY28uaWQiLCJpYXQiOjE2ODMwMzcxODgsImV4cCI6MTY4MzA0MDc4OH0.
        // EUDSjNwBVVVxj2aHdcZ_QJPl1bppgDfcvKRY_h7id8w";
        // $headers =[
        //     'Authorization' => 'Bearer' . $token
        // ];
        // $url = "http://localhost:8080/pasien/1";
        // $response = $client->request('GET',$url, ['headers'=>$headers,'http_errors'=>false]);

        // $url = "http://localhost:8080/pasien/";
        // $data=[
        //     'nama'=> 'Abdullah',
        //     'email' => 'abdullah@gmail.com'
        // ];
        // $response = $client->request('POST',$url, ['form_params'=>$data, 'headers'=>$headers,'http_errors'=>false]);
        
        // $url = "http://localhost:8080/pasien/7";
        // $data=[
        //     'nama'=> 'Abdullah',
        //     'email' => 'abdullah@gmail.com'
        // ];
        // $response = $client->request('PUT',$url, ['form_params'=>$data, 'headers'=>$headers,'http_errors'=>false]);
        
        // $data = [];
        // $url = "http://localhost:8080/pasien/7";
        // $response = $client->request('DELETE',$url, ['form_params'=>$data, 'headers'=>$headers,'http_errors'=>false]);
        // echo $response->getBody();

        helper(['restclient']);
        $url = "http://localhost/tbcrestapi/public/pasien";
        $data = [];
        $response = akses_restapi('GET',$url, $data);
        echo $response;
        // $dataArray = json_decode($response,true);
        // foreach($dataArray as $values){
        //     echo "NAMA: " . $values['nama'] . "<br/>";
        //     echo "EMAIL: " . $values['email'] . "<br/><br/>";
        // }
    }
}

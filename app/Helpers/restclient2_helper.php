<?php
use App\Models\ModelToken;

function akses_restapi($method, $url, $data)
{
    $client = \Config\Services::curlrequest();
    // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
    // eyJlbWFpbCI6ImZhaXNoYWxobWdAeWFob28uY28uaWQiLCJpYXQiOjE2ODMwMzkyMTUsImV4cCI6MTY4MzA0MjgxNX0.
    // 16Ogp4zqsXiPGuKKu1csknByJq8TBcuYMd0YN9bg5OA";
    $model = new ModelToken();
    $idToken = "1";
    $token = $model->getToken($idToken);
    $tokenPart = explode(".",$token);
    $payload = $tokenPart[1];
    $decode = base64_decode($payload);
    $json = json_decode($decode, true);
    $exp = $json['exp'];
    $waktuSekarang = time();
    if($exp <= $waktuSekarang)
    {
        $PasienModel = new ModelPasien();
        $nikOrEmail  = $this->request->getVar('nik_or_email');
        $password = $this->request->getVar('password');
        $user = $PasienModel->where('email', $nikOrEmail)->orWhere('nik', $nikOrEmail)->first();
  
        if(is_null($user)) {
            return $this->respond(['error' => 'Invalid Email/NIK atau password.'], 401);
        }
  
        $pwd_verify = password_verify($password, $user['password']);
  
        if(!$pwd_verify) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }
        $url = "http://localhost/tbcrestapi/public/api/login";
        $form_params = [
            'email' => $nikOrEmail,
            'password' => $password
        ];
        $response = $client->request('POST',$url,['http_errors'=>false,'form_params'=>
        $form_params]);
        $response = json_decode($response->getBody(),true);
        $token = $response['access_token'];
        $dataToken = [
            'id'=>$idToken,
            'token'=>$token
        ];
        $model->save($dataToken);
    }
    $headers = [
        'Authorization' => 'Bearer ' . $token
    ];
    
    $response = $client->request($method, $url, ['headers'=>$headers,
    'http_errors'=>false, 'form_params'=>$data]);
    return $response->getBody();
}
<?php

namespace App\Controllers;


use CodeIgniter\API\ResponseTrait;
use App\Models\ModelAuth;

class Auth extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $validation = \Config\Services::validation();
        $aturan = [
            'email' => [
                'rules' => 'required|valid_email',
                'error' => [
                    'required' => 'Silahkan masukan email',
                    'valid_email' => 'Silahkan masukan email yang valid'
                ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan masukan password',
                    ]
                ]
                    ];
        $validation->setRules($aturan);
        if(!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
        $model = new ModelAuth();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $model->getEmail($email);
        if($data['password'] != md5($password)){
            return $this->fail("Password tidak sesuai");
        }

        helper('jwt');
        $response = [
            'message' => 'otentifikasi berhasil dilakukan',
            'data' => $data,
            'access_token' => createJWT($email)
        ];
        return $this->respond($response);
    }
}
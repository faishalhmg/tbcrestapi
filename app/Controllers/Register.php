<?php
 
namespace App\Controllers;
 
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPasien;
 
 
class Register extends BaseController
{
    use ResponseTrait;
 
    public function index()
    {
        $rules = [
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[pasien.email]'],
            'nik' => ['rules' => 'required|min_length[16]|max_length[255]|is_unique[pasien.nik]'],
            'nama' => ['rules' => 'required|max_length[255]'],
            'username' => ['rules' => 'required|max_length[255]'],
            'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
            'confirm_password'  => [ 'label' => 'confirm password', 'rules' => 'matches[password]']
        ];
            
  
        if($this->validate($rules)){
            $model = new ModelPasien();
            $data = [
                'email'    => $this->request->getVar('email'),
                'nik'    => $this->request->getVar('nik'),
                'nama'    => $this->request->getVar('nama'),
                'username' => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);
             
            return $this->respond(['message' => 'Registered Successfully'], 200);
        }else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 409);
             
        }
            
    }
}
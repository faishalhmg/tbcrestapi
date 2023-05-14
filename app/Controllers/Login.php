<?php
 
namespace App\Controllers;
 
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPasien;
// use \Firebase\JWT\JWT;
 
class Login extends BaseController
{
    use ResponseTrait;
     
    public function index()
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
 
        // $key = getenv('JWT_SECRET_KEY');
        // $iat = time(); // current timestamp value
        // $exp = $iat + 3600;
 
        $payload = array(
       
            "email" => $user['email'],
            "id" => $user['id'],
            "nama" => $user['nama'],
            "username" => $user['username'],
            "email" => $user['email'],
            "nik" => $user['nik'],
            "alamat" => $user['alamat'],
            "usia" => $user['usia'],
            "no_hp" => $user['no_hp'],
            "goldar" => $user['goldar'],
            "bb" => $user['bb'],
            "kaderTB" => $user['kaderTB'],
            "pmo" => $user['pmo'],
            "pet_kesehatan" => $user['pet_kesehatan'],
            "jk" => $user['jk'],
        );
         
        helper('jwt');
 
        $response = [
            'message' => 'Login Succesful',
            'data' => $payload,
            'token' => createJWT($nikOrEmail)
        ];
         
        return $this->respond($response, 200);
    }
 
}
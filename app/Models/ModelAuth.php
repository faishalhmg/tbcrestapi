<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ModelAuth extends Model
{
    protected $table = "auth";
    protected $primaryKey = "id";
    protected $allowedFields = ['email','nik', 'password'];

    function getEmail($email)
    {
        $builder = $this->table("auth");
        $data = $builder->where("email",$email)->first();
        if(!$data){
            throw new Exception("Data otentifikasi tidak ditemukan");
        }
        return $data;
    }
}
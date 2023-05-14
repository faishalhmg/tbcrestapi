<?php

namespace App\Models;
use CodeIgniter\Model;
use Exception;

class ModelPasien extends Model
{
    protected $table = "pasien";
    protected $primaryKey = "id";
    protected $allowedFields = ['nama','username','email','nik','password','alamat','usia','no_hp','goldar','bb','kaderTB','pmo','pet_kesehatan','jk'];

    protected $validationRules = [
        'nama'=>'required',
        'email'=>'required|valid_email',
        'nik'=>'required'
    ];
    protected $validationMessages = [
        'nama'=>[
            'required' => 'Silahkan masukan nama'
        ],
        'email'=>[
            'required' => 'Silahkan masukan email',
            'valid_email' => 'Email yang dimasukan tidak valid'
        ],
        'nik'=>[
            'required' => 'Silahkan masukan nik'
        ],
    ];
    function getNikOrEmail($nikOrEmail)
    {
        $builder = $this->table("pasien");
        $data = $builder->where('email', $nikOrEmail)->orWhere('nik', $nikOrEmail)->first();
        if(!$data){
            throw new Exception("Data otentifikasi tidak ditemukan");
        }
        return $data;
    }
}

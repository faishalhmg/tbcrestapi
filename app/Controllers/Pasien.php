<?php

namespace App\Controllers;


use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPasien;

class Pasien extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->model = new ModelPasien();
    }

    public function index()
    {
        $data =$this->model->orderBy('nama','asc')->findAll();
        return $this->respond($data, 200);
    }
    public function show($nikOrEmail = null)
    {
        $PasienModel = new ModelPasien();
        $data = $PasienModel->where('email', $nikOrEmail)->orWhere('nik', $nikOrEmail)->first();
        $payload = array(
            "email" => $data['email'],
            "id" => $data['id'],
            "nama" => $data['nama'],
            "username" => $data['username'],
            "email" => $data['email'],
            "nik" => $data['nik'],
            "alamat" => $data['alamat'],
            "usia" => $data['usia'],
            "no_hp" => $data['no_hp'],
            "goldar" => $data['goldar'],
            "bb" => $data['bb'],
            "kaderTB" => $data['kaderTB'],
            "pmo" => $data['pmo'],
            "pet_kesehatan" => $data['pet_kesehatan'],
            "jk" => $data['jk'],
        );
        if($data){
            $response = [
                'data' => $payload,
            ];
            return $this->respond($response,200);
        }else{
            return $this->failNotFound("data tidak ditemukan untuk id $id");
        }
    }

    public function create()
    {
        // $data = [
        //     'nama' => $this->request->getVar('nama'),
        //     'email' => $this->request->getVar('email'),
        //     'nik' => $this->request->getVar('nik'),
        //     'alamat' => $this->request->getVar('alamat'),
        //     'usia' => $this->request->getVar('usia'),
        //     'no_hp' => $this->request->getVar('no_hp'),
        //     'goldar' => $this->request->getVar('goldar'),
        //     'bb' => $this->request->getVar('bb'),
        //     'pmo' => $this->request->getVar('pmo'),
        //     'kaderTB' => $this->request->getVar('kaderTB'),
        //     'pet_kesehatan' => $this->request->getVar('pet_kesehatan'),
        //     'jk' => $this->request->getVar('jk')
        // ];
        $data = $this->request->getPost();
        // $this->model->save($data);
        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }
        $response = [
            'status' => 201,
            'error' => null,
            'masseges' =>[
                'success' => 'Berhasil memasuki data pasien'
            ]
        ];
        return $this->respond($response);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $isExists = $this->model->where('id', $id)->findAll();

        if(!$isExists){
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }

        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }
        $data1 = $this->model->where('id',$id)->first();
        $payload = array(
            "email" => $data1['email'],
            "id" => $data1['id'],
            "nama" => $data1['nama'],
            "username" => $data1['username'],
            "email" => $data1['email'],
            "nik" => $data1['nik'],
            "alamat" => $data1['alamat'],
            "usia" => $data1['usia'],
            "no_hp" => $data1['no_hp'],
            "goldar" => $data1['goldar'],
            "bb" => $data1['bb'],
            "kaderTB" => $data1['kaderTB'],
            "pmo" => $data1['pmo'],
            "pet_kesehatan" => $data1['pet_kesehatan'],
            "jk" => $data1['jk'],
        );

        $response = [
            'status' => 200,
            'error' => null,
            'data' => $payload,
            'message' => [
                'success' => "Data pasien dengan id $id berhasil diupdate"
            ]
            ];
            return $this->respond($response);
    }

    public function delete($id = null)
    {
        $data = $this->model->where('id',$id)->findAll();
        if($data){
            $this->model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message'=>[
                    'success' => 'Data berhasil dihapus'
                ]
                ];
                return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}

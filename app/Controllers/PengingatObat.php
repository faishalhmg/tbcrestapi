<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPengingatobat;

class PengingatObat extends BaseController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\ModelPengingatobat';
	protected $format = 'json';

    public function __construct()
    {
        $this->model = new ModelPengingatobat();
    }

	public function index(){
		$data = $this->model->findAll();
		return $this->respond($data);
	}

	public function create(){
		helper(['form']);

		$rules = [
			'judul' => 'required',
			'hari' => 'required',
            'waktu' => 'required',
            'id_pasien' => 'required'
		];

		if(!$this->validate($rules)){
			return $this->fail($this->validator->getErrors());
		}else{
			$data = [
				'judul' => $this->request->getVar('judul'),
				'hari' => $this->request->getVar('hari'),
				'waktu' => $this->request->getVar('waktu'),
                'id_pasien'=> $this->request->getVar('id_pasien'),
			];

			$id = $this->model->insert($data);
			$data['id'] = $id;
			return $this->respondCreated($data);
		}
	}

	public function show($id_pasien = null){
		$data = $this->model->where('id_pasien',$id_pasien)->findAll();
		return $this->respond($data);
	}

	public function update($id = null){
		$data = $this->request->getRawInput();
        $data['id'] = $id;
        $isExists = $this->model->where('id', $id)->findAll();

        if(!$isExists){
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }

        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => "Pengingat Obat pasien dengan id $id berhasil diupdate"
            ]
            ];
            return $this->respond($response);

	}

	public function delete($id = null){
		$data = $this->model->find($id);
		if($data){
			$this->model->delete($id);
			return $this->respondDeleted($data);
		}else{
			return $this->failNotFound('Item not found');
		}
	}



	//--------------------------------------------------------------------

}

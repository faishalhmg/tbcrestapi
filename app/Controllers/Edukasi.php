<?php namespace App\Controllers;

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelEdukasi;

class Edukasi extends BaseController
{
    use ResponseTrait;
	protected $modelName = 'App\Models\ModelEdukasi';
	protected $format = 'json';

    public function __construct()
    {
        $this->model = new ModelEdukasi();
    }

	public function index(){
		$posts = $this->model->findAll();
		return $this->respond($posts);
	}

	public function create(){
		helper(['form']);
        

		$rules = [
			'judul' => 'required|min_length[6]',
			'isi' => 'required',
			'media' => 'uploaded[media]|max_size[media,1000000]|mime_in[media,image/jpg,image/jpeg,image/png,image/gif,video/mp4]|ext_in[media,jpg,jpeg,png,gif,mp4]',
		];

		if(!$this->validate($rules)){
			return $this->fail($this->validator->getErrors());
		}else{

			//Get the file
			$file = $this->request->getFile('media');
			if(! $file->isValid())
				return $this->fail($file->getErrorString());

			$file->move('./assets/uploads');

			$data = [
				'judul' => $this->request->getVar('judul'),
				'isi' => $this->request->getVar('isi'),
				'media' => $file->getName(),
                'created_by'=>$this->request->getVar('created_by'),
			];

			$id = $this->model->insert($data);
			$data['id'] = $id;
			return $this->respondCreated($data);
		}
	}

	public function show($id = null){
		$data = $this->model->find($id);
		return $this->respond($data);
	}

	public function update($id = null){
		helper(['form', 'array']);
        

		$rules = [
			'judul' => 'required|min_length[6]',
			'isi' => 'required',
		];


		$fileName = dot_array_search('media.name', $_FILES);

		if($fileName != ''){
			$media = ['media' => 'uploaded[media]|max_size[media,1000000]|mime_in[media,image/jpg,image/jpeg,image/png,image/gif,video/mp4]|ext_in[media,jpg,jpeg,png,gif,mp4]'];
			$rules = array_merge($rules, $media);
		}



		if(!$this->validate($rules)){
			return $this->fail($this->validator->getErrors());
		}else{
			//$input = $this->request->getRawInput();
            $data0 = $this->model->find($id);
            $path = $data0['media'];
            if(file_exists("./assets/uploads/".$path))
            {
                unlink("./assets/uploads/".$path);
            }


			$data = [
				'id' => $id,
				'judul' => $this->request->getVar('judul'),
				'isi' => $this->request->getVar('isi'),
			];

			if($fileName != ''){

				$file = $this->request->getFile('media');
				if(! $file->isValid())
					return $this->fail($file->getErrorString());

				$file->move('./assets/uploads');
				$data['media'] = $file->getName();
			}

			$this->model->save($data);
			return $this->respond($data);
		}

	}

	public function delete($id = null){
		$data = $this->model->find($id);
        
		if($data){
            $path = $data['media'];
            if(file_exists("./assets/uploads/".$path))
            {
                unlink("./assets/uploads/".$path);
            }
			$this->model->delete($id);
			return $this->respondDeleted($data);
		}else{
			return $this->failNotFound('Item not found');
		}
	}



	//--------------------------------------------------------------------

}
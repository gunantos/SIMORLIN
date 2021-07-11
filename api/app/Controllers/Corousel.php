<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\CorouselModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Corousel extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];
    private $folder = 'image'.DIRECTORY_SEPARATOR.'corousel'.DIRECTORY_SEPARATOR;
	function __construct() {
		$this->model = new CorouselModel();
	}

    public function index() {
        $page = (int) $this->request->getGet('page');
        $size = (int) $this->request->getGet('size');
        if ($page < 1) {
            $page = 1;
        }
        if ($size < 1 && $size >= 0) {
            $size = 10;
        } else if ($size > 10000) {
            $size = 10;
        }
        if ($size > 0) {
             $_page = ($page - 1) * $size;
             $data = $this->model->findAll($size, $_page);
        } else {
             $data = $this->model->findAll();
        }
        $total = (int) $this->model->count();

        return $this->respond(['status'=>true, 'data'=>$data, 'total'=>$total]);
    }

    public function show($id = null) {
        return $this->respond(['status'=>true, 'data'=>$this->model->find($id)]);
    }

	public function create() {
        $file = [];
        if ($imagefile=  $this->request->getFiles()) {
            foreach($imagefile['file'] as $img) {
                if ($img->isValid() && ! $img->hasMoved()){
                    $newname = $img->getRandomName();
                    $img->move(FCPATH.$this->folder);
                    array_push($file, base_url().'/'.$this->folder.$img->getName());
                }
            }
        }
        if (sizeof($file) > 0) {
            foreach($file as $fl) {
                $save = $this->model->insert(['img'=>$fl]);
            }
            if ($save) {
                 return $this->respond(['status'=>true, 'message'=>'Berhasil menyimpan data']);
            } else {
                 return $this->respond(['status'=>true, 'message'=>'Gagal menyimpan data']);
            }
        } else {
            return $this->respond(['status'=>true, 'message'=>'Gambar masih kosong']);
        }
	}

    public function delete($id = null) {
        $img = $this->model->find($id);
        if (!empty($img)) {
            if (isset($img->img)) {
                $image = $img->img;
                $image = \str_replace(\base_url().'/', FCPATH, $image);
                $image = \str_replace('/', DIRECTORY_SEPARATOR, $image);
                if (\file_exists($image)) {
                    @\unlink($image);
                }
            } else {
                return $this->respond(['status'=>true, 'message'=>'Data tidak ditemukan']);
            }
        } else {
            return $this->respond(['status'=>true, 'message'=>'Data tidak ditemukan']);
        }
        if ($this->model->delete($id)) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menghapus data']);
        } else {
            return $this->respond(['status'=>true, 'message'=>'Gagal menghapus data']);
        }
    }
}

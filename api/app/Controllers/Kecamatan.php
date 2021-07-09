<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\KecamatanModal;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Kecamatan extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new KecamatanModal();
	}

    public function index() {
        $page = (int) $this->request->getGet('page');
        $size = (int) $this->request->getGet('size');
        if ($page < 1) {
            $page = 1;
        }
        if ($size < 0) {
            $size = 10;
        } else if ($size > 500) {
            $size = 10;
        }
        
        return $this->respond(['status'=>true, 'data'=>$this->model->findAll($size, $page)]);
    }

    public function show($id = null) {
        return $this->respond(['status'=>true, 'data'=>$this->model->find($id)]);
    }

	public function create() {
		$PHPAUTH = new Authentication($this->config);
        $token = $PHPAUTH->token()->encode($this->user_api);
        return $this->respond(['status'=>true, 'token'=>$token, 'isadmin'=>true]);
	}

    public function update($id = null) {

    }

    public function delete($id = null) {
        if ($this->model->delete($id)) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menghapus data']);
        } else {
            return $this->respond(['status'=>true, 'message'=>'Gagal menghapus data']);
        }
    }
}

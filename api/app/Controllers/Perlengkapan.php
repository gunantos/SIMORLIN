<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\PerlengkapanModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Perlengkapan extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new PerlengkapanModel();
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
        $nama = $this->request->getPost('nama_perlengkapan');
        $icon = $this->request->getPost('icon_perlengkapan');
        if (empty($nama)) {
            return $this->respond(['status'=>false, 'message'=>'Data masih kosong']);
        }
        if ($this->model->insert(['nama_perlengkapan'=>$nama, 'icon_perlengkapan'=>$icon])) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menambahkan data']);
        } else {
            return $this->respond(['status'=>false, 'message'=>'Gagal menambahkan data']);
        }
	}

    public function update($id = null) {
        $nama = $this->request->getVar('nama_perlengkapan');
        $icon = $this->request->getVar('icon_perlengkapan');
        if (empty($id)) {
             return $this->respond(['status'=>false, 'message'=>'Tentukan data yang ingin di edit']);
        }
        if (empty($nama)) {
            return $this->respond(['status'=>false, 'message'=>'Data masih kosong']);
        }
        if ($this->model->update($id, ['nama_perlengkapan'=>$nama, 'icon_perlengkapan'=>$icon])) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menyimpan data']);
        } else {
            return $this->respond(['status'=>false, 'message'=>'Gagal menyimpan data']);
        }
    }

    public function delete($id = null) {
        if ($this->model->delete($id)) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menghapus data']);
        } else {
            return $this->respond(['status'=>true, 'message'=>'Gagal menghapus data']);
        }
    }
}

<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\JalanModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Jalan extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new JalanModel();
	}

    public function index() {
        $page = (int) $this->request->getGet('page');
        $size = (int) $this->request->getGet('size');
        $id_desa = $this->request->getGet('id_desa');
        $id_ruas_jalan = $this->request->getGet('id_ruas_jalan');
        
        if ($page < 1) {
            $page = 1;
        }
         if ($size < 1 && $size >= 0) {
            $size = 10;
        } else if ($size > 10000) {
            $size = 10;
        }
        $where = [];
        if (!empty($id_desa) && $id_desa != 'null') {
            $where['jalan.id_desa'] = $id_desa;
        }
        if (!empty($id_jalan) && $id_jalan != 'null') {
            $where['jalan.id_jalan'] = $id_jalan;
        }
        
        $_page = ($page - 1) * $size;

        $total = (int) $this->model->count($where);
        return $this->respond(['status'=>true, 'data'=>$this->model->getListJalan($size, $_page, $where), 'total'=>$total]);
    }

    public function show($id = null) {
        return $this->respond(['status'=>true, 'data'=>$this->model->find($id)]);
    }

	public function create() {
        $nama_jalan = $this->request->getPost('nama_jalan');
        $id_desa = $this->request->getPost('id_desa');
        $id_ruas_jalan = $this->request->getPost('id_ruas_jalan');
        if (empty($nama_jalan) || empty($id_desa)) {
            return $this->respond(['status'=>false, 'message'=>'Data tidak boleh kosong']);
        }
        if ($this->model->insert(['nama_jalan'=>$nama_jalan, 'id_desa'=>$id_desa, 'id_ruas_jalan'=>$id_ruas_jalan])) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menambahkan data']);
        } else {
            return $this->respond(['status'=>false, 'message'=>'Gagal menambahkan data']);
        }
	}

    public function update($id = null) {
         $nama_jalan = $this->request->getVar('nama_jalan');
        $id_desa = $this->request->getVar('id_desa');
        $id_ruas_jalan = $this->request->getVar('id_ruas_jalan');
        if (empty($id)) {
             return $this->respond(['status'=>false, 'message'=>'Tentukan data yang ingin di edit']);
        }
         if (empty($nama_jalan) || empty($id_desa)) {
            return $this->respond(['status'=>false, 'message'=>'Data tidak boleh kosong']);
        }
        if ($this->model->update($id, ['nama_jalan'=>$nama_jalan, 'id_desa'=>$id_desa, 'id_ruas_jalan'=>$id_ruas_jalan])) {
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

<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\KebutuhanModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Kebutuhan extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new KebutuhanModel();
	}

    public function index() {
        $page = (int) $this->request->getGet('page');
        $size = (int) $this->request->getGet('size');
        $id_kecamatan = $this->request->getGet('id_kecamatan');
        $id_desa = $this->request->getGet('id_desa');
        $id_jalan = $this->request->getGet('id_jalan');
        $id_perlengkapan = $this->request->getGet('id_perlengkapan');
        $id_arah_jalan = $this->request->getGet('id_arah_jalan');
        $id_kebutuhan = $this->request->getGet('id_kebutuhan');
        if ($page < 1) {
            $page = 1;
        }
         if ($size < 1 && $size >= 0) {
            $size = 10;
        } else if ($size > 10000) {
            $size = 10;
        }
        $where = [];
        if (!empty($id_kecamatan) && $id_kecamatan != 'null') {
            $where['desa.id_kecamatan'] = $id_kecamatan;
        }
        if (!empty($id_desa) && $id_desa != 'null') {
            $where['jalan.id_desa'] = $id_desa;
        }
        if (!empty($id_jalan) && $id_jalan != 'null') {
            $where['kebutuhan.id_jalan'] = $id_jalan;
        }
        if (!empty($id_perlengkapan) && $id_perlengkapan != 'null') {
            $where['kebutuhan.id_perlengkapan'] = $id_perlengkapan;
        }
        
        if (!empty($id_arah_jalan) && $id_arah_jalan != 'null') {
            $where['kebutuhan.id_arah_jalan'] = $id_arah_jalan;
        }
        $_page = ($page - 1) * $size;

        $total = (int) $this->model->count($where);

        return $this->respond(['status'=>true, 'data'=>$this->model->getList($size, $_page, $where), 'total'=>$total]);
    }

    public function show($id = null) {
        return $this->respond(['status'=>true, 'data'=>$this->model->find($id)]);
    }

	public function create() {
        $id_arah_jalan = $this->request->getPost('id_arah_jalan');
        $id_perlengkapan = $this->request->getPost('id_perlengkapan');
        $id_ruas_jalan = $this->request->getPost('id_ruas_jalan');
        $id_jalan = $this->request->getPost('id_jalan');
        $altitude = $this->request->getPost('altitude');
        $longitude = $this->request->getPost('longitude');
        if (empty($id_arah_jalan) || empty($id_perlengkapan) || empty($id_jalan) ||  empty($altitude) || empty($longitude)) {
            return $this->respond(['status'=>false, 'message'=>'Semua data tidak boleh kosong']);
        }
        $message = 'terjadi kesalahan';
        $data = [
                    'id_arah_jalan'=>$id_arah_jalan,
                    'id_perlengkapan'=>$id_perlengkapan,
                    'id_jalan'=>$id_jalan,
                    'id_ruas_jalan'=>$id_ruas_jalan,
                    'altitude'=>$altitude,
                    'longitude'=>$longitude
            ];
        $save = $this->model->save($data);
        if ($save) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menambahkan data']);
        } else {
            return $this->respond(['status'=>false, 'message'=>'Gagal menambahkan data']);
        }
	}

    public function update($id = null) {
        $id_arah_jalan = $this->request->getVar('id_arah_jalan');
        $id_perlengkapan = $this->request->getVar('id_perlengkapan');
        $id_jalan = $this->request->getVar('id_jalan');
        $altitude = $this->request->getVar('altitude');
        $longitude = $this->request->getVar('longitude');
        if (empty($id)) {
             return $this->respond(['status'=>false, 'message'=>'Tentukan data yang ingin di edit']);
        }
         if (empty($id_arah_jalan) || empty($id_perlengkapan) || empty($id_jalan)  || empty($altitude) || empty($longitude)) {
            return $this->respond(['status'=>false, 'message'=>'Semua data tidak boleh kosong']);
        }
         $data = [
                'id_arah_jalan'=>$id_arah_jalan,
                'id_perlengkapan'=>$id_perlengkapan,
                'id_jalan'=>$id_jalan,
                'kondisi'=>$kondisi,
                'altitude'=>$altitude,
                'longitude'=>$longitude
        ];
        if ($this->model->update($id, $data)) {
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

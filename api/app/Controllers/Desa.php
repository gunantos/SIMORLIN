<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\DesaModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Desa extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new DesaModel();
	}

    public function index() {
        $page = (int) $this->request->getGet('page');
        $size = (int) $this->request->getGet('size');
        $id_kecamatan = $this->request->getGet('id_kecamatan');
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
        
        $_page = ($page - 1) * $size;

        $total = (int) $this->model->count($where);

        return $this->respond(['status'=>true, 'data'=>$this->model->getListDesa($size, $_page, $where), 'total'=>$total]);
    }

    public function show($id = null) {
        return $this->respond(['status'=>true, 'data'=>$this->model->find($id)]);
    }

	public function create() {
        $kode = $this->request->getPost('kode_desa');
        $nama = $this->request->getPost('nama_desa');
        $id_kecamatan = $this->request->getPost('id_kecamatan');
        $kelurahan = $this->request->getPost('kelurahan');
        if ($kelurahan == true || $kelurahan == 'ya') {
            $kelurahan = 1;
        } else {
            $kelurahan = 0;
        }
        if (empty($kode) || empty($nama) || empty($id_kecamatan)) {
            return $this->respond(['status'=>false, 'message'=>'Kode dan nama masih kosong']);
        }
        if ($this->model->insert(['kode_desa'=>$kode, 'nama_desa'=>$nama, 'kelurahan'=>$kelurahan, 'id_kecamatan'=>$id_kecamatan])) {
            return $this->respond(['status'=>true, 'message'=>'Berhasil menambahkan data']);
        } else {
            return $this->respond(['status'=>false, 'message'=>'Gagal menambahkan data']);
        }
	}

    public function update($id = null) {
        $kode = $this->request->getVar('kode_desa');
        $nama = $this->request->getVar('nama_desa');
        $kelurahan = $this->request->getVar('kelurahan');
        $id_kecamatan = $this->request->getVar('id_kecamatan');
        if ($kelurahan == true || $kelurahan == 'ya') {
            $kelurahan = 1;
        } else {
            $kelurahan = 0;
        }
        if (empty($id)) {
             return $this->respond(['status'=>false, 'message'=>'Tentukan data yang ingin di edit']);
        }
        if (empty($kode) || empty($nama) || empty($id_kecamatan)) {
            return $this->respond(['status'=>false, 'message'=>'Data masih kosong']);
        }
        if ($this->model->update($id, ['kode_desa'=>$kode, 'nama_desa'=>$nama, 'kelurahan'=>$kelurahan, 'id_kecamatan'=>$id_kecamatan])) {
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

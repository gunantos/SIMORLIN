<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\TersediaModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Tersedia extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new TersediaModel();
	}

    public function index() {
        $page = (int) $this->request->getGet('page');
        $size = (int) $this->request->getGet('size');
        $id_kecamatan = $this->request->getGet('id_kecamatan');
        $id_desa = $this->request->getGet('id_desa');
        $id_jalan = $this->request->getGet('id_jalan');
        $id_ruas_jalan = $this->request->getGet('id_ruas_jalan');
        $id_perlengkapan = $this->request->getGet('id_perlengkapan');
        $id_arah_jalan = $this->request->getGet('id_arah_jalan');
        $id_tersedia = $this->request->getGet('id_tersedia');
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
            $where['tersedia.id_jalan'] = $id_jalan;
        }
        if (!empty($id_perlengkapan) && $id_perlengkapan != 'null') {
            $where['tersedia.id_perlengkapan'] = $id_perlengkapan;
        }
        
        if (!empty($id_arah_jalan) && $id_arah_jalan != 'null') {
            $where['tersedia.id_arah_jalan'] = $id_arah_jalan;
        }
        $_page = ($page - 1) * $size;

        $total = (int) $this->model->count($where);

        return $this->respond(['status'=>true, 'data'=>$this->model->getList($size, $_page, $where), 'total'=>$total]);
    }

    protected function uploud($filename, $folder, &$message = '') {
        if (!empty($this->request->getFile($filename))) {
            $file = $this->request->getFile($filename);
            $allowed = ['JPG', 'JPEG', 'PNG', 'BMP'];
            if (!in_array(strtoupper($file->getClientExtension()), $allowed)) {
                $message = 'File format tidak didukung, format yang didukung '. \implode(', ', $allowed);
                return false;
            }
            if (!$file->isValid()) {
                $message = 'File masih kosong';
                return false;
            }
            $file->move(FCPATH.$folder);
            $hasil = base_url().'/'.$folder.$file->getName();
            $hasil = \str_replace(DIRECTORY_SEPARATOR, '/', $hasil);
            return $hasil;
        }
        $message = 'Tentukan file yang ingin di simpan';
        return false;
    }
    public function show($id = null) {
        return $this->respond(['status'=>true, 'data'=>$this->model->find($id)]);
    }

	public function create() {
        $id_arah_jalan = $this->request->getPost('id_arah_jalan');
        $id_perlengkapan = $this->request->getPost('id_perlengkapan');
        $id_ruas_jalan = $this->request->getPost('id_ruas_jalan');
        $id_jalan = $this->request->getPost('id_jalan');
        $kondisi = $this->request->getPost('kondisi');
        $altitude = $this->request->getPost('altitude');
        $longitude = $this->request->getPost('longitude');
        $id_tersedia = $this->request->getPost('id_tersedia');
        if (empty($id_arah_jalan) || empty($id_perlengkapan) || empty($id_jalan) || empty($kondisi) || empty($altitude) || empty($longitude)) {
            return $this->respond(['status'=>false, 'message'=>'Semua data tidak boleh kosong']);
        }
        if ($id_tersedia == 'null') {
            $id_tersedia = '';
        }
        $message = 'terjadi kesalahan';
        $data = [
                    'id_arah_jalan'=>$id_arah_jalan,
                    'id_perlengkapan'=>$id_perlengkapan,
                    'id_jalan'=>$id_jalan,
                    'id_ruas_jalan'=>$id_ruas_jalan,
                    'kondisi'=>$kondisi,
                    'altitude'=>$altitude,
                    'longitude'=>$longitude
            ];
        if (empty($id_tersedia)) {
            $gambar_rambu = $this->uploud('gambar_rambu', 'image'.DIRECTORY_SEPARATOR .'rambu'.DIRECTORY_SEPARATOR , $message);
            if (!$gambar_rambu) {
            return $this->respond(['status'=>false, 'message'=>$message]);
            }
            $gambar_koordinat = $this->uploud('gambar_koordinat', 'image'.DIRECTORY_SEPARATOR .'koordinat'.DIRECTORY_SEPARATOR , $message);
            if (!$gambar_koordinat) {
            return $this->respond(['status'=>false, 'message'=>$message]);
            }   
            $data['gambar_rambu'] = $gambar_rambu;
            $data['gambar_koordinat'] = $gambar_koordinat;
            $save = $this->model->update($id_tersedia, $data);
        } else {
            $gambar_rambu = $this->uploud('gambar_rambu', 'image'.DIRECTORY_SEPARATOR .'rambu'.DIRECTORY_SEPARATOR , $message);
            if ($gambar_rambu) {
               $data['gambar_rambu'] = $gambar_rambu;
            }
            $gambar_koordinat = $this->uploud('gambar_koordinat', 'image'.DIRECTORY_SEPARATOR .'koordinat'.DIRECTORY_SEPARATOR , $message);
            if ($gambar_koordinat) {
               $data['gambar_koordinat'] = $gambar_koordinat;
            }   
            
            $save = $this->model->save($data);
        }
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
        $kondisi = $this->request->getVar('kondisi');
        $altitude = $this->request->getVar('altitude');
        $longitude = $this->request->getVar('longitude');
        if (empty($id)) {
             return $this->respond(['status'=>false, 'message'=>'Tentukan data yang ingin di edit']);
        }
         if (empty($id_arah_jalan) || empty($id_perlengkapan) || empty($id_jalan) || empty($kondisi) || empty($altitude) || empty($longitude)) {
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

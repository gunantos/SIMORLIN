<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class DashboardModel extends Model
{
    protected $table = 'tersedia';
    protected $primaryKey = 'id_tersedia';

    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $allowedFields = ['id_arah_jalan'];
    
    public function top() {
        $db = $this->db->table('tersedia')->select('COUNT("id_tersedia") as ttl')->get()->getRow();
        $db2 = $this->db->table('kebutuhan')->select('COUNT("id_kebutuhan") as ttl')->get()->getRow();
        $tersedia = 0;
        $dibutuhkan = 0;
        if ($db) {
            $tersedia = $db->ttl;
        }
        if ($db2) {
            $dibutuhkan = $db2->ttl;
        }
        return ['status'=>true,'tersedia'=>$tersedia, 'dibutuhkan'=>$dibutuhkan];
    }
    public function grafik() {
        $db = $this->db->table('kecamatan')->select('id_kecamatan, nama_kecamatan')->get()->getResult();
        $data = [];
        if ($db) {
            $tersedia= $this->db->table('tersedia')->select('COUNT(id_tersedia) as ttl, desa.id_kecamatan')
                ->join('jalan', 'tersedia.id_jalan=jalan.id_jalan', 'left')
                ->join('desa', 'desa.id_desa=jalan.id_desa', 'left')
                ->join('kecamatan', 'kecamatan.id_kecamatan=desa.id_kecamatan', 'left')
                ->groupBy('desa.id_kecamatan, kecamatan.nama_kecamatan')
                ->get()->getResult();
            $kebutuhan= $this->db->table('kebutuhan')->select('COUNT(id_kebutuhan) as ttl, desa.id_kecamatan')
                ->join('jalan', 'kebutuhan.id_jalan=jalan.id_jalan', 'left')
                ->join('desa', 'desa.id_desa=jalan.id_desa', 'left')
                ->join('kecamatan', 'kecamatan.id_kecamatan=desa.id_kecamatan', 'left')
                ->groupBy('desa.id_kecamatan, kecamatan.nama_kecamatan')
                ->get()->getResult();
            
            foreach($db as $key) {
                $ind = array_search($key->id_kecamatan, array_column($tersedia, 'id_kecamatan'));
                $dat = $key;
                if ($ind > -1) {
                    $dat->tersedia = $tersedia[$ind]->ttl;
                } else {
                    $dat->tersedia = 0;
                }
                $ind2 = array_search($key->id_kecamatan, array_column($tersedia, 'id_kecamatan'));
                $dat = $key;
                if ($ind2 > -1) {
                    $dat->dibutuhkan = $kebutuhan[$ind]->ttl;
                } else {
                    $dat->dibutuhkan = 0;
                }
                array_push($data, $dat);
            }
        }
        return ['status'=>true,'data'=>$data];
    }
}
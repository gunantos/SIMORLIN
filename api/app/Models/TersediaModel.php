<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class TersediaModel extends Model
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
    protected $allowedFields = ['id_arah_jalan', 'id_perlengkapan', 'id_jalan', 'id_ruas_jalan', 'gambar_rambu', 'gambar_koordinat', 'kondisi', 'altitude', 'longitude'];

    public function count($where=[]) {
        $db = $this->db->table($this->table)->select('count('. $this->table .'.'. $this->primaryKey .') as ttl')
                ->where($where)
                ->join('jalan', 'jalan.id_jalan='. $this->table.'.id_jalan', 'left')
                ->join('arah_jalan', 'arah_jalan.id_arah_jalan='. $this->table.'.id_arah_jalan', 'left')
                ->join('jenis_perlengkapan', 'jenis_perlengkapan.id_jenis_pelengkapan='. $this->table.'.id_perlengkapan', 'left')
                ->join('desa', 'desa.id_desa=jalan.id_desa', 'left')
                ->join('kecamatan', 'kecamatan.id_kecamatan=desa.id_kecamatan', 'left')
                ->where($this->table.'.'. $this->deletedField .' is NULL', null)
                ->get();
        if ($db) {
            $gt = $db->getRow();
            return $gt->ttl;
        }
        return 0;
    }

    public function getList($limit = 10, $start = 0, $where = []) {
        $db = $this->db->table($this->table)
            ->select(
                'tersedia.id_tersedia,  tersedia.id_ruas_jalan, tersedia.id_arah_jalan, tersedia.id_perlengkapan, tersedia.id_jalan, tersedia.gambar_rambu, tersedia.gambar_koordinat, tersedia.kondisi, tersedia.altitude, tersedia.longitude, tersedia.created, tersedia.updated,
                jalan.id_desa, jalan.nama_jalan, jalan.id_ruas_jalan,
                arah_jalan.nama_arah_jalan,
                jenis_perlengkapan.nama_perlengkapan, jenis_perlengkapan.icon_perlengkapan,
                desa.id_kecamatan, desa.kode_desa, desa.nama_desa, desa.kelurahan,
                kecamatan.kode_kecamatan, kecamatan.nama_kecamatan,
                ruas_jalan.nama_ruas_jalan
                '
            );
        if ($limit > 0) {
            $db ->limit($limit, $start);
        }
        return $db
            ->join('jalan', 'jalan.id_jalan='. $this->table.'.id_jalan', 'left')
            ->join('arah_jalan', 'arah_jalan.id_arah_jalan='. $this->table.'.id_arah_jalan', 'left')
            ->join('jenis_perlengkapan', 'jenis_perlengkapan.id_jenis_pelengkapan='. $this->table.'.id_perlengkapan', 'left')
            ->join('desa', 'desa.id_desa=jalan.id_desa', 'left')
            ->join('kecamatan', 'kecamatan.id_kecamatan=desa.id_kecamatan', 'left')
            ->join('ruas_jalan', 'ruas_jalan.id_ruas_jalan='. $this->table.'.id_ruas_jalan', 'left')
            ->where($this->table.'.'. $this->deletedField .' is NULL', null)
            ->where($where)
            ->get()->getResultArray();
    }
}
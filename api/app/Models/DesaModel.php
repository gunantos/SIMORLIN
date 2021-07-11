<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class DesaModel extends Model
{
    protected $table = 'desa';
    protected $primaryKey = 'id_desa';

    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $allowedFields = ['kode_desa', 'nama_desa', 'id_kecamatan', 'kelurahan'];
    
    
    public function count($where=[]) {
        $db = $this->db->table($this->table)->select('count('. $this->primaryKey .') as ttl')
                ->where($where)
                ->where($this->deletedField .' is NULL')
                ->get();
        if ($db) {
            $gt = $db->getRow();
            return $gt->ttl;
        }
        return 0;
    }
    public function getListDesa($limit = 10, $start = 0, $where = []) {
        $db = $this->db->table($this->table)
            ->where($where);
        if ($limit > 0) {
            $db ->limit($limit, $start);
        }
        return $db->join('kecamatan', 'kecamatan.id_kecamatan='. $this->table.'.id_kecamatan', 'left')
            ->where($this->table.'.'. $this->deletedField .' is NULL', null)
            ->get()->getResultArray();
    }
}
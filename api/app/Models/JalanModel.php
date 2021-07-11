<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class JalanModel extends Model
{
    protected $table = 'jalan';
    protected $primaryKey = 'id_jalan';

    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $allowedFields = ['nama_jalan', 'id_desa', 'id_ruas_jalan'];

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
    public function getListJalan($limit = 10, $start = 0, $where = []) {
        $db = $this->db->table($this->table)
            ->where($where);
         if ($limit > 0) {
            $db ->limit($limit, $start);
        }
         return $db->join('ruas_jalan', 'ruas_jalan.id_ruas_jalan='. $this->table.'.id_ruas_jalan', 'left')
            ->join('desa', 'desa.id_desa='. $this->table.'.id_desa', 'left')
            ->where($this->table.'.'. $this->deletedField .' is NULL', null)
            ->get()->getResultArray();
    }
}
<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class KecamatanModal extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $allowedFields = ['kode_kecamatan', 'id_kecamatan', 'nama_kecamatan'];

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
}
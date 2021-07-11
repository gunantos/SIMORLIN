<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class PerlengkapanModel extends Model
{
    protected $table = 'jenis_perlengkapan';
    protected $primaryKey = 'id_jenis_pelengkapan';

    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $allowedFields = ['nama_perlengkapan', 'icon_perlengkapan'];
    
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
<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class CorouselModel extends Model
{
    protected $table = 'corousel';
    protected $primaryKey = 'idcorousel';

    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';
    protected $allowedFields = ['title', 'text', 'img'];
    
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
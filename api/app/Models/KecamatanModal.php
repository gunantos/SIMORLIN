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
}
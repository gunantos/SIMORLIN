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
}
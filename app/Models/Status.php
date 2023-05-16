<?php

namespace App\Models;

use CodeIgniter\Model;

class Status extends Model
{
    protected $table            = 'status';
    protected $allowedFields    = ['created_at', 'updated_at', 'deleted_at', 'status_mesin'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getStatus($id)
    {
        return $this->where([
            'id' => $id
        ])->first();
    }
}

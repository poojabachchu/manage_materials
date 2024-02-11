<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InwardOutward extends Model
{
    use HasFactory;
    protected $table = "inward_outward";
    protected $primaryKey = 'inward_id';
}

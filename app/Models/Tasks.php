<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    public $table = "tasks";
    public $primarykey = "id";
    public $foreignkey = "id_project";
    public $foreignkey2 = "id_user";
    public $timestamps = false;
}

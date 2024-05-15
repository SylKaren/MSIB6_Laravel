<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table ='staff';
    protected $primarikey ='id';
    protected $fillable = [
        'nip',
        'name',
        'gender',
        'alamat',
        'email',];
}

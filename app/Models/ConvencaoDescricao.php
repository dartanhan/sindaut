<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvencaoDescricao extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_convencao_descricao';
    protected $fillable = ['descricao', 'updated_at', 'created_at'];
}

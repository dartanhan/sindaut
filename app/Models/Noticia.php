<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_noticias2';
    protected $fillable = ['data', 'titulo', 'conteudo', 'status', 'updated_at', 'created_at'];

}

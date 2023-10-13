<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriaImagem extends Model
{
    use HasFactory;
    protected $table = "tbl_sindaut_galeria_imagems";
    protected $fillable = ['path', 'updated_at', 'created_at'];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }
}

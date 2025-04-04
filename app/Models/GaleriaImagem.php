<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriaImagem extends Model
{
    use HasFactory;
    protected $table = "tbl_sindaut_galeria_imagens";
    protected $fillable = ['path','file_id', 'updated_at', 'created_at'];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }

    public function convencao()
    {
        return $this->belongsTo(Convencao::class);
    }
}

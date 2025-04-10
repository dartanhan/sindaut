<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convencao extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_convencao';
    protected $fillable = ['titulo_cct', 'data_cct', 'descricao_cct','file_id','status', 'updated_at', 'created_at'];

    public function files()
    {
        return $this->hasMany(GaleriaImagem::class,'id','file_id');
    }

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }
}

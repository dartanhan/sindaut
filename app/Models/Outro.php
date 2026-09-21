<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outro extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_outros';
    protected $fillable = ['tipo', 'tipo_id', 'titulo', 'conteudo', 'status', 'updated_at', 'created_at'];

    const TIPO_CONTRIBUICOES = 'contribuicoes';
    const ID_CONTRIBUICOES = 1;

    const TIPO_ENQUADRAMENTO = 'enquadramento';
    const ID_ENQUADRAMENTO = 2;

    public function scopeContribuicoes($query)
    {
        return $query->where('tipo', self::TIPO_CONTRIBUICOES);
    }

    public function scopeEnquadramento($query)
    {
        return $query->where('tipo', self::TIPO_ENQUADRAMENTO);
    }

    public function getCreatedAtAttribute()
    {
        return isset($this->attributes['created_at']) && $this->attributes['created_at'] 
            ? date('d/m/Y H:i:s', strtotime($this->attributes['created_at'])) 
            : null;
    }

    public function getUpdatedAtAttribute()
    {
        return isset($this->attributes['updated_at']) && $this->attributes['updated_at'] 
            ? date('d/m/Y H:i:s', strtotime($this->attributes['updated_at'])) 
            : null;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepJuridico extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_depjuridicos';
    protected $fillable = ['conteudo','status', 'updated_at', 'created_at'];

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

}

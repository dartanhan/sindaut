<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_noticias';
    protected $fillable = ['titulo', 'conteudo', 'subtitulo','status','imagem_id', 'updated_at', 'created_at'];

    protected static function booted()
    {
        static::saved(function ($noticia) {
            \Illuminate\Support\Facades\Cache::forget('site:sidebar_noticias');
            \Illuminate\Support\Facades\Cache::forget('site:ticker_noticias');
            \Illuminate\Support\Facades\Cache::forget('site:home_noticias');
        });

        static::deleted(function ($noticia) {
            \Illuminate\Support\Facades\Cache::forget('site:sidebar_noticias');
            \Illuminate\Support\Facades\Cache::forget('site:ticker_noticias');
            \Illuminate\Support\Facades\Cache::forget('site:home_noticias');
        });
    }

    public function imagens()
    {
        return $this->hasMany(GaleriaImagem::class,'id','imagem_id');
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

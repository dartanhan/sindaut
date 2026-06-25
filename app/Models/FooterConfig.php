<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterConfig extends Model
{
    use HasFactory;

    protected $table = 'tbl_sindaut_footer';

    protected $fillable = [
        'logo_path',
        'telefone',
        'email',
        'endereco',
        'cep',
        'cidade_estado',
        'copyright',
        'redes_sociais',
        'fale_conosco',
        'sede_telefone',
        'sede_email',
        'sede_endereco',
        'subsede_telefone',
        'subsede_endereco',
    ];

    protected $casts = [
        'redes_sociais' => 'array',
        'fale_conosco'  => 'array',
    ];

    /**
     * Singleton: retorna o único registro ou cria com valores padrão.
     */
    public static function config(): self
    {
        return static::firstOrCreate([], [
            'telefone'      => '',
            'email'         => '',
            'endereco'      => '',
            'cep'           => '',
            'cidade_estado' => '',
            'copyright'     => 'SINDAUT-RIO',
            'redes_sociais' => [
                'facebook'  => '',
                'instagram' => '',
                'youtube'   => '',
            ],
            'fale_conosco'    => [],
            'sede_telefone'   => '',
            'sede_email'      => '',
            'sede_endereco'   => '',
            'subsede_telefone'=> '',
            'subsede_endereco'=> '',
        ]);
    }
}

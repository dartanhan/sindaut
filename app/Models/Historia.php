<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    use HasFactory;
    protected $table = 'tbl_sindaut_historia';
    protected $fillable = ['conteudo'];
}

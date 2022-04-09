<?php

namespace App\Models;

use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class Eletrodomestico extends Model
{
    use HasFactory;

    protected $table = 'eletrodomestico';
    protected $fillable = ['descricao', 'marca_id'];


    public static function hasEletrodomestico($descricao, $marca_id, $id = 0)
    {
        return self::whereDescricao($descricao)->whereMarcaId($marca_id)->where('id', '<>', $id)->first();
    }

    public function marca(){
        return $this->belongsTo(Marca::class,'marca_id');
    }
}

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

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marca';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ToDoList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'to_do_lists';

    protected $fillable = [
        'id',
        'user_id',
        'titulo',
        'descripcion',
        'status',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function user()
    {
        return $this
        ->hasOne('App\Models\User','id','user_id');
    }

    public function getCreatedAtAttribute($date)
    {
        $dia = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('l, d');
        $mes = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('F');
        $anio = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('Y');
        $hora = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('h:i A');
        $fecha = ucfirst($dia) . ' de ' . ucfirst($mes) . ' del ' . ucfirst($anio) . ' a las '.$hora;
        return $fecha;    
        
    }

    public function getUpdatedAtAttribute($date)
    {
        $dia = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('l, d');
        $mes = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('F');
        $anio = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('Y');
        $hora = Carbon::parse($date)->setTimezone('America/Mexico_City')->translatedFormat('h:i A');
        $fecha = ucfirst($dia) . ' de ' . ucfirst($mes) . ' del ' . ucfirst($anio) . ' a las '.$hora;
        return $fecha;       
    }
}

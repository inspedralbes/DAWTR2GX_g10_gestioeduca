<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    // Indicar el nombre de la tabla si no sigue la convención plural
    protected $table = 'resultats';

    protected $primaryKey = ['form_id', 'user_id'];

    // Especificar los campos que pueden ser asignados masivamente
    protected $fillable = [
        'form_id',
        'user_id',
        'totalAgressivitat',
        'agressivitatFisica',
        'agressivitatVerbal',
        'agressivitatRelacional',
        'totalAgressivitat_SN',
        'agressivitatFisica_SN',
        'agressivitatVerbal_SN',
        'agressivitatRelacional_SN',
        'prosocialitat',
        'prosocialitat_SN',
        'totalVictimitzacio',
        'victimitzacioFisica',
        'victimitzacioVerbal',
        'victimitzacioRelacional',
        'totalVictimitzacio_SN',
        'victimitzacioFisica_SN',
        'victimitzacioVerbal_SN',
        'victimitzacioRelacional_SN',
        'popular_SN',
        'rebutjat_SN',
        'ignorat_SN',
        'controvertit_SN',
        'norma_SN',
        'triesPositives_SN',
        'triesNegatives_SN',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Form (relación uno a muchos)
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    // Establecer los tipos de los atributos (opcional, pero recomendado para evitar problemas)
    protected $casts = [
        'totalAgressivitat' => 'integer',
        'agressivitatFisica' => 'integer',
        'agressivitatVerbal' => 'integer',
        'agressivitatRelacional' => 'integer',
        'prosocialitat' => 'integer',
        'totalVictimitzacio' => 'integer',
        'victimitzacioFisica' => 'integer',
        'victimitzacioVerbal' => 'integer',
        'victimitzacioRelacional' => 'integer',
    ];
}

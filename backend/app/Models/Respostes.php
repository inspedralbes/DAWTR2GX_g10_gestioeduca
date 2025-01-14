<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respostes extends Model
{
    use HasFactory;

    // Definir la tabla si el nombre no sigue la convención de pluralización
    protected $table = 'respostes';

    // Definir la clave primaria si es diferente a 'id' (en tu caso es una clave compuesta)
    protected $primaryKey = ['form_id', 'user_id'];

    // Para evitar que Laravel intente autogenerar los timestamps automáticamente
    public $timestamps = true;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'form_id',
        'user_id',
        'genero',
        'tutor',
        'centro',
        'poblacion',
        'soc_POS_1_user_id',
        'soc_POS_2_user_id',
        'soc_POS_3_user_id',
        'soc_NEG_1_user_id',
        'soc_NEG_2_user_id',
        'soc_NEG_3_user_id',
        'ar_i_1_user_id',
        'ar_i_2_user_id',
        'ar_i_3_user_id',
        'pros_1_user_id',
        'pros_2_user_id',
        'pros_3_user_id',
        'af_1_user_id',
        'af_2_user_id',
        'af_3_user_id',
        'ar_d_1_user_id',
        'ar_d_2_user_id',
        'ar_d_3_user_id',
        'pros_2_1_user_id',
        'pros_2_2_user_id',
        'pros_2_3_user_id',
        'av_1_user_id',
        'av_2_user_id',
        'av_3_user_id',
        'vf_1_user_id',
        'vf_2_user_id',
        'vf_3_user_id',
        'vv_1_user_id',
        'vv_2_user_id',
        'vv_3_user_id',
        'vr_1_user_id',
        'vr_2_user_id',
        'vr_3_user_id',
        'amics_1_user_id',
        'amics_2_user_id',
        'amics_3_user_id',
    ];

    // Relación con el modelo User (relación uno a muchos)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Form (relación uno a muchos)
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    // Relaciones con los campos específicos de usuario
    public function socPos1User()
    {
        return $this->belongsTo(User::class, 'soc_POS_1_user_id');
    }

    public function socPos2User()
    {
        return $this->belongsTo(User::class, 'soc_POS_2_user_id');
    }

    public function socPos3User()
    {
        return $this->belongsTo(User::class, 'soc_POS_3_user_id');
    }

    public function socNeg1User()
    {
        return $this->belongsTo(User::class, 'soc_NEG_1_user_id');
    }

    public function socNeg2User()
    {
        return $this->belongsTo(User::class, 'soc_NEG_2_user_id');
    }

    public function socNeg3User()
    {
        return $this->belongsTo(User::class, 'soc_NEG_3_user_id');
    }

    public function arI1User()
    {
        return $this->belongsTo(User::class, 'ar_i_1_user_id');
    }

    public function arI2User()
    {
        return $this->belongsTo(User::class, 'ar_i_2_user_id');
    }

    public function arI3User()
    {
        return $this->belongsTo(User::class, 'ar_i_3_user_id');
    }

    public function pros1User()
    {
        return $this->belongsTo(User::class, 'pros_1_user_id');
    }

    public function pros2User()
    {
        return $this->belongsTo(User::class, 'pros_2_user_id');
    }

    public function pros3User()
    {
        return $this->belongsTo(User::class, 'pros_3_user_id');
    }

    public function af1User()
    {
        return $this->belongsTo(User::class, 'af_1_user_id');
    }

    public function af2User()
    {
        return $this->belongsTo(User::class, 'af_2_user_id');
    }

    public function af3User()
    {
        return $this->belongsTo(User::class, 'af_3_user_id');
    }

    public function arD1User()
    {
        return $this->belongsTo(User::class, 'ar_d_1_user_id');
    }

    public function arD2User()
    {
        return $this->belongsTo(User::class, 'ar_d_2_user_id');
    }

    public function arD3User()
    {
        return $this->belongsTo(User::class, 'ar_d_3_user_id');
    }

    public function pros21User()
    {
        return $this->belongsTo(User::class, 'pros_2_1_user_id');
    }

    public function pros22User()
    {
        return $this->belongsTo(User::class, 'pros_2_2_user_id');
    }

    public function pros23User()
    {
        return $this->belongsTo(User::class, 'pros_2_3_user_id');
    }

    public function av1User()
    {
        return $this->belongsTo(User::class, 'av_1_user_id');
    }

    public function av2User()
    {
        return $this->belongsTo(User::class, 'av_2_user_id');
    }

    public function av3User()
    {
        return $this->belongsTo(User::class, 'av_3_user_id');
    }

    public function vf1User()
    {
        return $this->belongsTo(User::class, 'vf_1_user_id');
    }

    public function vf2User()
    {
        return $this->belongsTo(User::class, 'vf_2_user_id');
    }

    public function vf3User()
    {
        return $this->belongsTo(User::class, 'vf_3_user_id');
    }

    public function vv1User()
    {
        return $this->belongsTo(User::class, 'vv_1_user_id');
    }

    public function vv2User()
    {
        return $this->belongsTo(User::class, 'vv_2_user_id');
    }

    public function vv3User()
    {
        return $this->belongsTo(User::class, 'vv_3_user_id');
    }

    public function vr1User()
    {
        return $this->belongsTo(User::class, 'vr_1_user_id');
    }

    public function vr2User()
    {
        return $this->belongsTo(User::class, 'vr_2_user_id');
    }

    public function vr3User()
    {
        return $this->belongsTo(User::class, 'vr_3_user_id');
    }

    public function amics1User()
    {
        return $this->belongsTo(User::class, 'amics_1_user_id');
    }

    public function amics2User()
    {
        return $this->belongsTo(User::class, 'amics_2_user_id');
    }

    public function amics3User()
    {
        return $this->belongsTo(User::class, 'amics_3_user_id');
    }
}

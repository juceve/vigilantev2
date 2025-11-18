<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sistemaparametro
 *
 * @property $id
 * @property $tolerancia_ingreso
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sistemaparametro extends Model
{

    static $rules = [
		'tolerancia_ingreso' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tolerancia_ingreso', 'telefono_panico'];



}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',           // Nombre
        'last_name',      // Apellido
        'email',          // Correo electrónico
        'password',       // Contraseña
        'birthday',       // Fecha de nacimiento
        'pais',           // País
    ];

    /**
     * Los atributos que deberían ser ocultados para los arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',   // Para convertir la fecha de verificación de correo
            'birthday' => 'date',                 // Para convertir el campo 'birthday' a tipo fecha
            'password' => 'hashed',               // Para asegurarse de que la contraseña esté correctamente hasheada
        ];
    }
}

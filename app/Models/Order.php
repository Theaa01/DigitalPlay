<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'payer_email',
        'total_price',
        'items',
        'status'
    ];

    // Accesor para formatear fecha
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }

    // Accesor para el estado en texto legible
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'processing':
                return 'En Proceso';
            case 'completed':
                return 'Completado';
            default:
                return 'Pendiente';
        }
    }

    // Relación con usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación opcional con los ítems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_id',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'rooms',
        'nights',
        'subtotal',
        'tax',
        'total',
        'requests',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function isValid(): bool
    {
        $today = now()->startOfDay();

        if ($this->check_in < $today) {
            return false;
        }

        if ($this->room->available_rooms < $this->rooms) {
            return false;
        }

        return true;
    }

    public function getValidationError(): ?string
    {
        $today = now()->startOfDay();

        if ($this->check_in < $today) {
            return 'Tanggal check-in sudah lewat';
        }

        if ($this->room->available_rooms < $this->rooms) {
            return 'Stok kamar tidak mencukupi';
        }

        return null;
    }
}

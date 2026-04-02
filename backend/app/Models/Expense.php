<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Expense extends Model
{
    protected $fillable = [
        'expense_date',
        'project_name',
        'category',
        'title',
        'amount',
        'payment_type',
        'director_name',
        'notes',
        'receipt_path',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected $appends = [
        'receipt_url',
    ];

    protected function receiptUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->receipt_path ? Storage::disk('public')->url($this->receipt_path) : null,
        );
    }
}

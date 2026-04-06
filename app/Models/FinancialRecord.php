<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'category',
        'date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'date',
        ];
    }

    /**
     * Get the user who created this record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Format amount in Indian currency format.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₹' . $this->indianNumberFormat($this->amount);
    }

    /**
     * Format number in Indian numbering system (e.g., 1,23,456.00).
     */
    private function indianNumberFormat($number): string
    {
        $number = number_format((float) $number, 2, '.', '');
        $parts = explode('.', $number);
        $intPart = $parts[0];
        $decPart = $parts[1];

        $isNegative = false;
        if ($intPart[0] === '-') {
            $isNegative = true;
            $intPart = substr($intPart, 1);
        }

        if (strlen($intPart) <= 3) {
            return ($isNegative ? '-' : '') . $intPart . '.' . $decPart;
        }

        $lastThree = substr($intPart, -3);
        $remaining = substr($intPart, 0, -3);
        $formatted = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remaining) . ',' . $lastThree;

        return ($isNegative ? '-' : '') . $formatted . '.' . $decPart;
    }

    /**
     * Scope to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateBetween($query, $from, $to)
    {
        if ($from) {
            $query->where('date', '>=', $from);
        }
        if ($to) {
            $query->where('date', '<=', $to);
        }
        return $query;
    }
}

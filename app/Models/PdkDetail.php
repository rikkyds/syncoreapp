<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdkDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_request_id',
        'cost_category',
        'activity_name',
        'description',
        'volume',
        'unit',
        'unit_price',
        'total_price',
        'sort_order',
        'notes',
    ];

    protected $casts = [
        'volume' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function supportRequest()
    {
        return $this->belongsTo(SupportRequest::class);
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('cost_category', $category);
    }

    public function scopePersonil($query)
    {
        return $query->where('cost_category', 'personil');
    }

    public function scopeNonPersonil($query)
    {
        return $query->where('cost_category', 'non_personil');
    }

    public function scopeOrderedBySortOrder($query)
    {
        return $query->orderBy('sort_order');
    }

    // Accessors
    public function getFormattedVolumeAttribute()
    {
        return number_format($this->volume, 2, ',', '.');
    }

    public function getFormattedUnitPriceAttribute()
    {
        return number_format($this->unit_price, 0, ',', '.');
    }

    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 0, ',', '.');
    }

    public function getCategoryLabelAttribute()
    {
        $labels = [
            'personil' => 'Biaya Langsung Personil',
            'non_personil' => 'Biaya Non Personil',
        ];

        return $labels[$this->cost_category] ?? $this->cost_category;
    }

    // Mutators
    public function setVolumeAttribute($value)
    {
        $this->attributes['volume'] = $value;
        $this->calculateTotalPrice();
    }

    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value;
        $this->calculateTotalPrice();
    }

    // Methods
    public function calculateTotalPrice()
    {
        if (isset($this->attributes['volume']) && isset($this->attributes['unit_price'])) {
            $this->attributes['total_price'] = $this->attributes['volume'] * $this->attributes['unit_price'];
        }
    }

    public function recalculateTotal()
    {
        $this->total_price = $this->volume * $this->unit_price;
        $this->save();
        return $this->total_price;
    }

    // Static methods
    public static function getTotalByCategory($supportRequestId, $category)
    {
        return static::where('support_request_id', $supportRequestId)
                    ->where('cost_category', $category)
                    ->sum('total_price');
    }

    public static function getTotalPersonil($supportRequestId)
    {
        return static::getTotalByCategory($supportRequestId, 'personil');
    }

    public static function getTotalNonPersonil($supportRequestId)
    {
        return static::getTotalByCategory($supportRequestId, 'non_personil');
    }

    public static function getGrandTotal($supportRequestId)
    {
        return static::where('support_request_id', $supportRequestId)
                    ->sum('total_price');
    }

    // Boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateTotalPrice();
        });

        static::saved(function ($model) {
            // Update support request total when PDK detail is saved
            $model->supportRequest->updateRemainingBudget();
        });

        static::deleted(function ($model) {
            // Update support request total when PDK detail is deleted
            if ($model->supportRequest) {
                $model->supportRequest->updateRemainingBudget();
            }
        });
    }
}

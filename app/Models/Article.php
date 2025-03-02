<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_no',
        'date',
        'quantity',
        'extra_pcs',
        'category_id',
        'season_id',
        'size_id',
        'fabric_type',
        'sales_rate',
        'rates_array',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Setups::class, 'category_id')->where('type', 'pcs_category');
    }

    public function size()
    {
        return $this->belongsTo(Setups::class, 'size_id')->where('type', 'pcs_size');
    }

    public function season()
    {
        return $this->belongsTo(Setups::class, 'season_id')->where('type', 'pcs_season');
    }
}

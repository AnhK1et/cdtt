<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'specifications',
        'price',
        'sale_price',
        'stock',
        'image',
        'banner',
        'images',
        'brand',
        'color',
        'storage',
        'ram',
        'screen_size',
        'is_active',
        'is_featured',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $counter = 1;
                
                // Kiểm tra và tạo slug unique
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $product->slug = $slug;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Lấy đường dẫn ảnh sản phẩm
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Nếu image bắt đầu bằng "images/", đó là đường dẫn từ public
            if (strpos($this->image, 'images/') === 0) {
                return asset($this->image);
            }
            // Nếu không, đó là đường dẫn từ storage
            return asset('storage/' . $this->image);
        }
        return null;
    }
}

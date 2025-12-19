<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'banner',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Lấy đường dẫn ảnh category từ public/images
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
        
        // Nếu không có ảnh, tìm ảnh từ thư mục public/images dựa trên tên category
        $imageFolderMap = [
            'iPhone' => 'iphone',
            'Samsung' => 'samsung',
            'Xiaomi' => 'xiaomi',
            'OPPO' => 'oppo',
            'Vivo' => 'vivo',
            'Realme' => 'remi',
            'Laptop' => 'Laptop',
            'Ipad' => 'Ipad',
        ];
        
        $categoryName = $this->name;
        if (isset($imageFolderMap[$categoryName])) {
            $imageFolder = $imageFolderMap[$categoryName];
            $imagePath = public_path("images/{$imageFolder}");
            
            if (is_dir($imagePath)) {
                $files = glob($imagePath . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
                if (!empty($files)) {
                    $firstImage = basename($files[0]);
                    return asset("images/{$imageFolder}/{$firstImage}");
                }
            }
        }
        
        return null;
    }
}

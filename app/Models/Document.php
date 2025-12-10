<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $guarded = []; 

    // Relasi: Dokumen milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Dokumen termasuk 1 Kategori
    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }
}
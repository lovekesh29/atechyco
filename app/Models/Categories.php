<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public function getSubCategories(){
        return $this->hasMany(SubCategories::class, 'catId');
    }
}

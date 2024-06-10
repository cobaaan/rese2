<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    use HasFactory;
    
    protected $fillable = ['manager_id', 'area_id', 'genre_id',  'name', 'description', 'image_path'];
    
    public function manager(){
        return $this->belongsTo(User::class);
    }
    
    public function reserves() {
        return $this->hasMany(Reserve::class);
    }
    
    public function area(){
        return $this->belongsTo(Area::class);
    }
    
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}

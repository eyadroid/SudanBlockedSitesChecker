<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteRequest extends Model
{
    use HasFactory;

    protected $fillable = ["website_id", "is_success"];


    function website() {
        return $this->belongsTo("App\Models\Website");
    }
}

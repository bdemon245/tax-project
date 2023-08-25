<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;
    protected $guarded = []; 
    protected $casts = [
        'name' => Json::class,
    ]; 

    function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guarantor extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'guarantor_code', 'code');
    }
}

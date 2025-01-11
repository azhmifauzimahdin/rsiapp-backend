<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];
    protected $with = ['guarantor'];

    protected $hidden = [
        'guarantor_code',
        'ip_address'
    ];

    public function guarantor(): BelongsTo
    {
        return $this->belongsTo(Guarantor::class, 'guarantor_code', 'code');
    }
}

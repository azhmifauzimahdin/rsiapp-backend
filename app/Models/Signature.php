<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];
    protected $appends = ['image_url'];

    protected $hidden = [
        'image'
    ];

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return asset('storage/images/signature/' . $this->image);
            }
        );
    }
}

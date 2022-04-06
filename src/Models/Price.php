<?php

namespace Notabenedev\SiteGroupPrice\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class Price extends Model
{
    use HasFactory, ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "price",
        "description",
    ];

    protected static function booting() {

        parent::booting();
    }

    /**
     * Price group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function group(){
        return $this->belongsTo(\App\Group::class);
    }

    /**
     * Изменить дату создания.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return datehelper()->changeTz($value);
    }



}

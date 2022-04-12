<?php

namespace Notabenedev\SiteGroupPrice\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;

class Group extends Model
{
    use HasFactory, ShouldSlug, ShouldMetas;

    protected $fillable = [
        "title",
        "slug",
        "short",
        "description",
        "accent",
        "info",
        "nested",
    ];
    protected $metaKey = "groups";

    protected static function booting() {

        parent::booting();
    }

    /**
     * Родительская группа.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(\App\Group::class, "parent_id");
    }

    /**
     * Дочерние группы.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(\App\Group::class, "parent_id");
    }

    /**
     * Уровень вложенности.
     *
     * @return int
     */
    public function getNestingAttribute()
    {
        if (empty($this->parent_id)) {
            return 1;
        }
        return $this->parent->nesting + 1;
    }

    /**
     * Get parent publish status
     *
     * @return \Illuminate\Support\Carbon|mixed
     */

    public function isParentPublished(){

        $parent = $this->parent()->first();
        return $parent ? $parent->published_at : now();

    }

    /**
     * Change publish status
     *
     */
    public function publish()
    {
        $this->published_at = $this->published_at  ? null : now();
        $this->save();
    }

    /**
     * Change publish status all children
     *
     */

    public function publishCascade()
    {

        $published =  $this->published_at;
        $children = $this->children();
        $collection = $children->get();
        $parentPublished = $this->isParentPublished();

        // for parents groups
        if ($collection->count() > 0) {

            //unpublished group and child groups
            if ($published || !$parentPublished) {
                $this->published_at = null;
                $this->save();

                foreach ($collection as $child) {
                    $child->published_at = null;
                    $child->save();
                }

            } else {
                //publish group
                $this->publish();
            }
            return
                redirect()
                    ->back();

        }
        // for leaf groups
        else {
            //can't publish the leaf when parent is unpublished
            if (!$published  && !$parentPublished) {
                return redirect()
                    ->back();
            }
            $this->publish();

            return redirect()
                ->back();
        }
    }
    /**
     * Group prices
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(\App\Price::class);
    }
}

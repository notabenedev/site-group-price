<?php

namespace Notabenedev\SiteGroupPrice\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class PriceSideMd implements FilterInterface {

    public function applyFilter(File $image)
    {

        return $image
            ->fit(720,300);
    }
}
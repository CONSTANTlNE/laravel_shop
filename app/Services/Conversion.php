<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Conversion
{
    public function __construct() {}

    public function convert($file, $format = null)
    {

        try {
            $manager = new ImageManager(new Driver);

            return $manager->read($file)->toWebp(70);
        } catch (\Exception $exception) {
            return back()->with('alert_error', 'Conversion Error :'.$exception->getMessage());
        }

    }

    //
    //    public function thumbnail($file)

    //    {    6961558
    //
    //        $manager = new ImageManager(new Driver);
    //        $image = $manager->read($file);
    //        $custom = $image->cover(326, 280);
    //
    //        return $manager->read($custom)->toWebp(70);
    //
    //    }
    //
    //    public function scaleDown($file)

    //    {
    //
    //        $manager = new ImageManager(new Driver);
    //        $image = $manager->read($file);
    //        $custom = $image->scaleDown(350);
    //
    //        return $manager->read($custom)->toWebp(70);
    //
    //    }
}

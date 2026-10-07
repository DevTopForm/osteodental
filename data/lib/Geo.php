<?php

namespace App;

use App\Item\Region;
use App\Params;

class Geo
{
    public static function setRegion($region, $pref = 'p'): void
    {
        if (!is_null($region)) {
            setcookie(
                $pref . '_region',
                $region->id,
                time() + 60 * 60 * 24 * 30,
                '/',
                '.' . Params::$params['public']['site']['host']
            );
        }
    }

    public static function getRegion($pref = 'p'): ?Region
    {
        $region = null;

        if (!empty($_COOKIE[$pref . '_region'])) {
            $region = new Region((int)$_COOKIE[$pref . '_region']);
        }

        if (empty($region) || empty($region->id)) {
            $region = new Region(2);
        }

        return $region;
    }
}

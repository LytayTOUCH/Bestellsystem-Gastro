<?php

namespace App\Models;

use function GuzzleHttp\default_ca_bundle;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = "site_settings";
    public $timestamps = false;

    public static function getBackgroundModus() {
        switch (self::first()->site_template) {
            case "black":
                return "dark";
            case "white":
                return "light";
            default:
                return "light";
        }
    }
}

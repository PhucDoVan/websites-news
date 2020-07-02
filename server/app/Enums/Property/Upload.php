<?php

namespace App\Enums\Property;

use BenSampo\Enum\Enum;

define('PUBLIC_PATH', public_path());

final class Upload extends Enum
{
    const publicPath = PUBLIC_PATH;
    const UploadPath = self::publicPath.'/upload/';
    const TmpPath    = self::publicPath.'/tmp/';
}

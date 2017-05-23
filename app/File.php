<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    # file size Convert function
	public static function formatFileSize($size) {
	    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
	    for ($i = 0; $size > 1024; $i++) { $size /= 1024; }
	    return round($size, 2).$units[$i];
	}
}

<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Set Image given a img from database
 */
function useImage($image)
{
    if (str($image)->contains('uploads/')) {
        return asset("storage/$image");
    } else {
        return $image;
    }
}

/**
 * Returns current timestamp with unique identifier
 */
function timestamp()
{
    return Carbon::now()->format('Y-m-d-H-m:s:u');
}
/**
 * Stores an image given an image request and a directory
 *
 * @param string $prefix is empty 
 * getClientOriginalName will be used
 */
function saveImage($image, string $dir, string $prefix = '', string $disk = 'public')
{
    if ($prefix === '') {
        $prefix = str($image->getClientOriginalName())->slug();
    }
    $ext = $image->extension();
    $name = $prefix . "-" . timestamp() . '.' . $ext;
    $path = $image->storeAs("uploads/$dir", $name, $disk);
    return $path;
}

/**
 * Updates a file given a new file and old path
 * @return string $new_path
 */
function updateFile($file, $old_path, $dir,  $prefix = "image")
{
    $new_path = $old_path;
    $path = 'public/' . $old_path;
    $fileExists = Storage::exists($path);
    if ($fileExists) {
        if ($file) {
            $new_path = saveImage($file, $dir, $prefix);
            Storage::delete($path);
        }
    } else {
        $new_path = saveImage($file, $dir, $prefix);
    }
    return $new_path;
}

/**
 * Deletes a file given its path from database
 * 
 * Deletes only form public disks
 */
function deleteFile($path)
{
    $deleted = false;
    $path = 'public/' . $path;
    if (Storage::exists($path)) {
        $deleted = Storage::delete($path);
    }
    return $deleted;
}
/**
 * An Array for social media platform data
 */
function socialItems(): array
{
    $socialItems = [
        [
            'name' => 'facebook',
            'icon' => 'mdi mdi-facebook'
        ],
        [
            'name' => 'messenger',
            'icon' => 'mdi mdi-facebook-messenger'
        ],
        [
            'name' => 'twitter',
            'icon' => 'mdi mdi-twitter'
        ],
        [
            'name' => 'youtube',
            'icon' => 'mdi mdi-youtube'
        ],
        [
            'name' => 'whatsapp',
            'icon' => 'mdi mdi-whatsapp'
        ],
        [
            'name' => 'linkedin',
            'icon' => 'mdi mdi-linkedin'
        ],
        [
            'name' => 'telegram',
            'icon' => 'mdi mdi-telegram'
        ],
        [
            'name' => 'google+',
            'icon' => 'mdi mdi-google-plus'
        ],
        [
            'name' => 'snapchat',
            'icon' => 'mdi mdi-snapchat'
        ],
        [
            'name' => 'github',
            'icon' => 'mdi mdi-github'
        ],
    ];
    return $socialItems;
}


/**
 * Get records from the specified table with queries
 */
function getRecords($table = 'users', $queries = [], $limit = 10)
{
    if (count($queries) > 0) {
        if (!is_array($queries[0])) {
            $queries = [$queries];
        }
    }
    $records = DB::table($table)->where($queries)->limit($limit)->get();
    return $records;
}



/**
 * Get count for any given table from database
 */
function countRecords($table = 'users', $queries = [])
{
    if (count($queries) > 0) {
        if (!is_array($queries[0])) {
            $queries = [$queries];
        }
    }
    $count = DB::table($table)->where($queries)->count();
    return $count;
}


/**
 * Returns an image url from picsum.photos
 * 
 */
function picsum(string $seed = null,int $width= 720, int $height = null ) {
    if (!$height) {
        $height = $width;
    }
    if (!$seed) {
        $picsum = "https://picsum.photos/$width/$height";
    }else{
        $picsum = "https://picsum.photos/seed/$seed/$width/$height";
    }

    return $picsum;
}
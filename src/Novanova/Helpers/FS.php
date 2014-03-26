<?php

namespace Novanova\Helpers;


/**
 * Class FS
 * @package Novanova\Helpers
 */
class FS
{

    const MAKE_FILENAME_ATTEMPTS = 100;

    /**
     * @param $path
     * @param $ext
     * @return null|string
     */
    public static function makeFilename($path, $ext)
    {
        $filename = null;
        $path_part_1 = null;
        $path_part_2 = null;
        $path_part_3 = null;

        $DS = DIRECTORY_SEPARATOR;

        for ($i = 0; $i < self::MAKE_FILENAME_ATTEMPTS; $i++) {
            if (!$filename) {
                $filename = sha1(uniqid(microtime()));
                $path_part_3 = substr($filename, 0, 2);
                $path_part_2 = substr($filename, 2, 2);
                $path_part_1 = substr($filename, 4);
                $filename = $path_part_3 . $DS . $path_part_2 . $DS . $path_part_1 . $DS . $ext;
                if (is_file($path . $DS . $filename)) {
                    $filename = null;
                }
            }
        }
        if ($filename) {
            if (!is_dir($path . $DS . $path_part_3)) {
                mkdir($path . $DS . $path_part_3);
            }
            if (!is_dir($path . $DS . $path_part_3 . $DS . $path_part_2)) {
                mkdir($path . $DS . $path_part_3 . $DS . $path_part_2);
            }
        }
        return $filename;
    }

}
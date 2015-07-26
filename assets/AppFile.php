<?php

namespace c006\crud\assets;

use yii\base\Exception;

/**
 * Class AppFile
 *
 * @package c006\crud\assets
 */
class AppFile
{
    /**
     * Used with {recursiveDirectory}
     *  (Example)
     *  $path  = \Yii::getPathOfAlias('application.extensions.PayPal');
     *  $path  = AppFile::cleanBackslashInPath($path);
     *  $array = AppFile::recursiveDirectory($path, $path);
     *  $array = AppFile::recursiveAutoLoadClass($array);
     *  foreach ($array as $class) {
     *     $class = str_replace($path, '', $class);
     *     \Yii::import("application.extensions.PayPal" . $class);
     *  }
     *
     * @param $directory_array
     *
     * @return array
     */
    static public function autoLoadClassArray($directory_array)
    {
        $array_out = array();
        foreach ($directory_array as $items) {
            foreach ($items as $array) {
                if (!$array['is_dir'] && $array['extension'] == 'php')
                    $array_out[] = $array['path'] . '/' . $array['file'];
                else if (isset($array['sub_folders'])) {
                    $array_out = array_merge((array)$array_out, (array)self::autoLoadClassArray($array['sub_folders']));
                }
            }
        }

        return $array_out;
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    static public function useForwardSlash($path)
    {
        return str_replace('/', chr(92), $path);
    }

    /**
     * Unifies all slashes to backslash
     *
     * @param $path
     *
     * @return mixed
     */
    static public function useBackslash($path)
    {
        return str_replace(chr(92), '/', $path);
    }

    /**
     * @param $source
     * @param $dest
     */
    static public function copyDirectory($source, $dest)
    {
        if (!is_dir($source))
            return;
        if (!is_dir($dest))
            @mkdir($dest);
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir($source . "\\" . $file)) {
                    AppFile:: copyDirectory($source . "\\" . $file, $dest . "\\" . $file);
                } else if (is_file($source . "\\" . $file)) {
                    copy($source . "\\" . $file, $dest . "\\" . $file);
                }
            }
        }
    }

    /**
     * @param $source
     *
     * @return bool
     */
    static public function deleteDirectory($source)
    {
        if (!is_dir($source))
            return FALSE;
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir($source . "/" . $file)) {
                    AppFile:: deleteDirectory($source . "/" . $file);
                    //                        chmod($source . "/" . $file, 0777);
                    unlink($source . "/" . $file);
                } else if (is_file($source . "/" . $file)) {
                    //                        chmod($source . "/" . $file, 0777);
                    unlink($source . "/" . $file);
                }
            }
        }

        return TRUE;
    }

    /**
     * @param $path
     */
    static public function deleteEmptyDirectory($path)
    {
        @unlink($path);
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    static public function removeFileInPath($path)
    {
        $file = self::fileFromPath($path);

        return str_replace($file, '', $path);

    }

    /**
     * @param $path
     *
     * @return mixed
     */
    static public function  fileFromPath($path)
    {
        $path = str_replace('\\', '/', $path);
        $f = explode('/', $path);

        return $f[ sizeof($f) - 1 ];
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    static public function getLastFolderInPath($path)
    {
        $path = AppFile::useBackslash($path);
        $array = explode('/', $path);

        return $array[ sizeof($array) - 1 ];
    }


    /**
     * @param $path
     *
     * @return mixed
     */
    static public function getFirstFolderInPath($path)
    {
        $path = AppFile::useBackslash($path);
        $array = explode('/', $path);

        return $array[0];
    }

    /**
     * @param $filePath
     *
     * @return string
     */
    static public function readFile($filePath)
    {
        return file_get_contents($filePath);
    }

    /**
     * @param $path
     * @param $base_path
     *
     * @return array
     */
    static public function recursiveDirectory($path, $base_path)
    {
        $array = array();
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item != "." && $item != "..") {
                if (is_file($path . "/" . $item)) {
                    $array[]['item'] = array(
                        'is_dir'    => FALSE,
                        'path'      => $path,
                        'relative'  => str_replace($base_path, '', $path),
                        'file'      => $item,
                        'extension' => AppFile::fileExtension($item),
                    );
                }
            }
        }
        foreach ($items as $item) {
            if ($item != "." && $item != "..") {
                if (is_dir($path . "/" . $item)) {
                    $array[]['item'] = array(
                        'is_dir'      => TRUE,
                        'path'        => $path,
                        'relative'    => str_replace($base_path, '', $path),
                        'folder'      => $item,
                        'depth'       => AppFile::folderCountInPath(str_replace($base_path, '', $path . "/" . $item)),
                        'sub_folders' => AppFile::recursiveDirectory($path . "/" . $item, $base_path),
                    );
                }
            }
        }

        return $array;
    }

    /**
     * @param $file_name
     *
     * @return mixed
     */
    static public function  fileExtension($file_name)
    {
        $f = explode('.', $file_name);

        return $f[ sizeof($f) - 1 ];
    }

    /**
     * @param $path
     *
     * @return int
     */
    static public function folderCountInPath($path)
    {
        $path = AppFile::useBackslash($path);
        $path = AppFile::removeTrailingBackSlash($path);

        return sizeof(explode('/', $path));
    }

    /**
     * @param $path
     *
     * @return string
     */
    static public function removeTrailingBackSlash($path)
    {
        if (substr($path, strlen($path) - 1, 1) == "/") {
            return substr($path, 0, strlen($path) - 1);
        }

        return $path;
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    static public function removeDoubleBackslash($path)
    {
        return str_replace('//', '/', $path);
    }

    /**
     * @param $filePath
     * @param $data
     */
    static public function writeFile($filePath, $data)
    {
        @unlink($filePath);
        try {
            $fh = fopen($filePath, 'w');
            fwrite($fh, $data);
            fclose($fh);
        } catch (Exception $e) {
            die("AppFile :: writeFile :: Can't write file <br> {$filePath}");
        }

    }

    /**
     * @param $file
     *
     * @return string
     */
    static public function cleanFileName($file)
    {
        $ext = self::fileExtension($file);
        $file = self::removeFileExtension($file);
        $file = preg_replace('/[^0-9|A-Z|a-z|_|-]/', '', $file);

        return $file . '.' . $ext;
    }

    /**
     * @param $file_name
     *
     * @return string
     */
    static public function  removeFileExtension($file_name)
    {
        $f = explode('.', $file_name);
        unset($f[ sizeof($f) - 1 ]);

        return implode('.', $f);
    }

    /**
     * @param $path
     */
    static public function buildPath($path)
    {
        $path = self::useBackslash($path);
        $array = explode('/', $path);
        $build = '';
        foreach ($array as $item) {
            $build .= '/' . $item;
            if (!is_dir($build)) {
                mkdir($build);
            }
        }
    }


}

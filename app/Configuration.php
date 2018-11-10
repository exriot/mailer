<?php

namespace App;

use Exriot\Profile;


abstract class Configuration
{
    /** @var Profile */
    private static $profile;

    public static function getProfile(): Profile
    {
        if(!static::$profile){
            static::$profile = new Profile(static::getUserFile());
            static::$profile->read();
        }
        return static::$profile;
    }

    public static function setValue(string $name, string $value)
    {
        static::getProfile()
            ->set($name, $value)
            ->save();
    }

    /**
     * @return string
     * @throws \Exception Thrown when the user home directory is not detected
     */
    private static function getUserFile(): string
    {
        exec('echo $HOME', $output, $_);
        if(is_array($output) && isset($output[0])){
            return $output[0] . '/.phar-mailer';
        }else{
            throw new \Exception('failed to get the user home directory');
        }
    }

    final public static function getDefaultCsvFile(): string
    {
        return static::getDir() . '/recipients.csv';
    }

    final public static function getSubjectFile(): string
    {
        return static::getDir() . '/subject.txt';
    }

    final public static function getBodyTextFile(): string
    {
        return static::getDir() . '/body.txt';
    }

    final public static function getBodyHtmlFile(): string
    {
        return static::getDir() . '/body.html';
    }

    final public static function getLastCacheNth(): int
    {
        $caches = static::getCacheFiles();
        if(empty($caches)) {
            return -1;
        }else{
            $last = array_pop($caches);
            $nth = substr(basename($last), 0, strrpos($last, '.'));
            return (int)$nth;
        }
    }

    final public static function getCacheFiles(): array
    {
        $dir = static::getDir();
        $items = array_diff(scandir($dir), ['.','..']);
        $caches = array_filter(array_map(function(string $item){
            return strpos($item, '.cache') ? $item : false;
        }, $items));
        sort($caches);
        $caches = array_values(array_map(function(string $item)use($dir){
            return $dir . '/' . $item;
        }, $caches));
        return $caches;
    }

    final public static function getCacheFile(int $nth): string
    {
        return static::getDir() . '/' . $nth . '.cache';
    }

    private static function getDir(): string
    {
        return getcwd();
    }
}

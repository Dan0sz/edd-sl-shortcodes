<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita1377b8a1b96e109aec963de59239d87
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Daan\\EDD\\SoftwareLicensing\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Daan\\EDD\\SoftwareLicensing\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita1377b8a1b96e109aec963de59239d87::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita1377b8a1b96e109aec963de59239d87::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita1377b8a1b96e109aec963de59239d87::$classMap;

        }, null, ClassLoader::class);
    }
}

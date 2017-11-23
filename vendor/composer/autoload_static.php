<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit468cef116c3076a984dbf184e6774307
{
    public static $files = array (
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
        '7e702cccdb9dd904f2ccf22e5f37abae' => __DIR__ . '/..' . '/facebook/php-sdk-v4/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
            1 => __DIR__ . '/..' . '/facebook/php-sdk-v4/src/Facebook',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit468cef116c3076a984dbf184e6774307::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit468cef116c3076a984dbf184e6774307::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

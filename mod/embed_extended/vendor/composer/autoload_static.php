<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit664a13794ff49c69e11ada4a68c325ad
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit664a13794ff49c69e11ada4a68c325ad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit664a13794ff49c69e11ada4a68c325ad::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

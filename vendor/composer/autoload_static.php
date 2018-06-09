<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb7109043bdf126f4e4df6b316a2fc87d
{
    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpcmx\\common\\' => 14,
        ),
        'J' => 
        array (
            'JustFck\\ApiDoc\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpcmx\\common\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpcmx/common/src',
        ),
        'JustFck\\ApiDoc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb7109043bdf126f4e4df6b316a2fc87d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb7109043bdf126f4e4df6b316a2fc87d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite454c4f29a0afd25a04713834767a737
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite454c4f29a0afd25a04713834767a737::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite454c4f29a0afd25a04713834767a737::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

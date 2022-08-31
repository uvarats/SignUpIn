<?php

namespace App;

use Twig\Environment;

class View
{
    private static ?Environment $twigEnv = null;

    public function __construct()
    {
    }

    /**
     * @return Environment
     */
    public static function getTwig(): Environment
    {
        if(is_null(self::$twigEnv)) {
            $loader = new \Twig\Loader\FilesystemLoader(VIEWS_PATH);
            self::$twigEnv = new \Twig\Environment($loader, [
//                'cache' => VIEWS_PATH . '/cache',
            ]);
        }
        return self::$twigEnv;
    }

}
<?php

declare(strict_types=1);

namespace App;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

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
        if (is_null(self::$twigEnv)) {
            $loader = new FilesystemLoader(VIEWS_PATH);
            self::$twigEnv = new Environment($loader, [
                'cache' => VIEWS_PATH . '/cache',
            ]);
            self::$twigEnv->addGlobal('session', $_SESSION);
        }
        return self::$twigEnv;
    }
}

<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
//		$router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');

//        $router[] = new Route('<action>/<slug>', array(
//            'module' => 'Front:Employee',
//            'presenter' => 'Employee',
//            'action' => [
//                Route::VALUE => 'default',
//                Route::FILTER_TABLE => [
//                    "detail-projektu" => "detail",
//                    "blog" => "blog",
//                ],
//            ],
//            'lang' => 'sk'
//        ));


        $router[] = new Route('employee/<action>[/<id>]', array(
            'module' => 'Front:System',
            'presenter' => 'Employee',
            'action' => '',
            'id' => NULL,
        ));

        $router[] = new Route('<action>[/<id>]', array(
            'module' => 'Front:System',
            'presenter' => 'System',
            'action' => [
                Route::VALUE => 'default',
//                Route::FILTER_TABLE => [
//                    "projekty" => "project",
//                    "export-udajov" => "export",
//                    "prehlady" => "overview",
//                    "detail-projektu" => "detail",
//                    "aktuality" => "blogList",
//                    "namety" => "theme",
//                ],
            ],
            'lang' => 'sk'
        ));


		return $router;
	}
}

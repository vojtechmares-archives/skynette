<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nextras\Routing\StaticRouter;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
	    $router = new RouteList();

	    $router[] = new StaticRouter(['Homepage:cz' => 'index.php'], StaticRouter::ONE_WAY);

		$router[] = new StaticRouter([
		    'Homepage:en' => 'english',
		    'Homepage:cz' => '',
		    'About:en' => 'about-us',
            'About:cz' => 'o-nas',
            'Contact:en' => 'contact',
            'Contact:cz' => 'kontakt',
        ]);

        $router->addRoute('<presenter>/<action>[<id>]','Homepage:cz');

		return $router;
	}
}

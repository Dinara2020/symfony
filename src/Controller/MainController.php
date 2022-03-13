<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function start(): Response
    {
        return new Response(
            '<html><body><h1>Главная страница</h1>
			<p><a href="/api">Api из библиотеки</a></p>
			<p><a href="/custom_api/company/1">Custom Api</a></p>
			</body></html>'
        );
    }
}
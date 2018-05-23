<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PagesController extends Controller
{
	public function getHome(ServerRequestInterface $request, ResponseInterface $response)
	{
		return $response->withJson([
			'name' => $this->container->get('app_name'),
			'environment' => $this->container->get('env_name'),
			'description' => 'A search api with duckduckgo'
		]);
	}
}
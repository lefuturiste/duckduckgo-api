<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CorsMiddleware{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
	{
		if (isset($request->getServerParams()['HTTP_ORIGIN'])){
			$origin = $request->getServerParams()['HTTP_ORIGIN'];
			header("Access-Control-Allow-Origin: {$origin}");
		}else{
			header("Access-Control-Allow-Origin: *");
		}
		header("Access-Control-Allow-Methods: POST, PUT, GET");
		header("Access-Control-Allow-Headers: Origin, Content-Type, Authorisation");
		return $next($request, $response);
	}
}
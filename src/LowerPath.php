<?php

namespace Hiraeth\Middleware;

use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as Handler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;


/**
 *
 */
class LowerPath implements Middleware
{
	/**
	 *
	 */
	public function __construct(ResponseFactory $factory)
	{
		$this->factory = $factory;
	}


	/**
	 *
	 */
	public function process(Request $request, Handler $handler): Response
	{
		$uri  = $request->getUri();
		$path = strtolower($uri->getPath());

		if ($uri->getPath() != $path) {
			return $this->factory->createResponse(301)->withHeader('Location', $path);
		}

		return $handler->handle($request);
	}
}

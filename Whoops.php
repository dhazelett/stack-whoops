<?php

namespace Saphire\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Whoops\Run;

/**
 * Class Whoops
 * @package Saphire\Middleware
 */
class Whoops implements HttpKernelInterface
{

    /**
     * @var     HttpKernelInterface
     */
    private $app;

    /**
     * @var     array
     */
    private $options;

    public function __construct(HttpKernelInterface $app, array $options)
    {
        $this->app = $app;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $this->app['exception_handler']->disable();

        $handler = new Run();

        $handler->pushHandler(new $this->options['handler']);
        $handler->register();

        return $this->app->handle($request, $type, $catch);
    }

}

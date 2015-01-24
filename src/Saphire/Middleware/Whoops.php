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

    /**
     * {@inheritdoc}
     */
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

        $handler->allowQuit(false);

        if ($this->options['handler'] instanceof \Closure) {

            $handler->pushHandler($this->options['handler']);

        } elseif (is_string($this->options['handler'])) {

            $handler->pushHandler($this->options['handler']);

        } else {

            throw new \InvalidArgumentException(sprintf('%s requires a valid handler', __CLASS__));

        }

        $handler->register();

        $this->app['whoops_handler'] = $handler;

        return $this->app->handle($request, $type, $catch);
    }

}

# Stack-Whoops
Stack Middleware for Whoops, the cool kids error handler.

## Warning!
This Middleware has no tests, I honestly don't have time to write exception catching unit tests, I have a newborn. I really just wanted a middleware for whoops+stack. _feel free to send a PR with tests if it's that important_

## Usage

```php
use Silex\Application;
use Stack\Builder;

require_once '../app/config/bootstrap.php';

$app = new Application($config);

$stack = (new Builder)
    ->push('Saphire\Middleware\Whoops', [
        // STRING! name of the \Whoops\Handler\* to use
        'handler' => '\Whoops\Handler\PrettyPageHandler'
    ])
;

// Try it out
$app->get('/', function() {
    throw new \Exception('Oh No!');
});

$server = $stack->resolve($app);

$response = $server->handle($request)->send();

$server->terminate($request, $response);
```

###### MIT License

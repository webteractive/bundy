<?php

namespace App\Bundy;

use Illuminate\Routing\Router;

class Pathfinder
{
  protected $routes;

  protected $router;

  public function __construct(Router $router) {
    $this->routes = [];
    $this->router = $router;
  }

  public function compile()
  {
    foreach ($this->router->getRoutes() as $route) {
      if (! is_null($route->getName())) {
        $this->routes[] = [
          'uri' => $route->uri(),
          'name' => $route->getName()
        ];
      }
    }

    return $this->routes;
  }

  public function export()
  {
    $base = url('/');
    $settings = parse_url($base);
    $pathfinder = json_encode([
      'base' => $base,
      'host' => array_key_exists('host', $settings) ? $settings['host'] : '',
      'port' => array_key_exists('port', $settings) ? $settings['port'] : 'false',
      'scheme' => array_key_exists('scheme', $settings) ? $settings['scheme'] : 'http',
      'routes' => $this->compile()
    ]);

    return <<<EOT
<script type="text/javascript">
var PATHFINDER = $pathfinder;
</script>
EOT;
  }

}
<?php

namespace App;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

class ResourceRegistrar extends BaseResourceRegistrar
{
    protected $resourceDefaults = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
        'list',
    ];

    /**
     * Add the list method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    public function addResourceList($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/all';

        $action = $this->getResourceAction($name, $controller, 'list', $options);

        return $this->router->get($uri, $action);
    }
}

<?php

namespace Finite\Factory;

use Finite\Exception\FactoryException;
use Illuminate\Contracts\Container\Container;

/**
 * A concrete implementation of State Machine Factory using the L4+ dependency injection container
 *
 * @author Eelke van den Bos <eelke@vdbf.nl>
 */
class LaravelServiceContainerFactory extends AbstractFactory
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $key;

    /**
     * @param Container $container
     * @param string             $key
     */
    public function __construct(Container $container, $key)
    {
        $this->container = $container;
        $this->key       = $key;

        if (!$container->has($key)) {
            throw new FactoryException(
                sprintf(
                    'You must define the "%s" service as your StateMachine definition',
                    $key
                )
            );
        }
    }

    /**
     * @{inheritDoc}
     */
    protected function createStateMachine()
    {
        return $this->container->make($this->key);
    }
}

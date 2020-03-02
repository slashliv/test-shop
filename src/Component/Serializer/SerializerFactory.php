<?php

namespace App\Component\Serializer;

use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory implements SerializerFactoryInterface
{
    /**
     * @return SerializerInterface
     */
    public function create(): SerializerInterface
    {
        $builder = new SerializerBuilder();
        $builder->setPropertyNamingStrategy(new CamelCaseNamingStrategy());

        return $builder->build();
    }
}

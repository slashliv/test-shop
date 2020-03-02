<?php

namespace App\Component\Serializer;

use JMS\Serializer\SerializerInterface;

interface SerializerFactoryInterface
{
    public function create(): SerializerInterface;
}

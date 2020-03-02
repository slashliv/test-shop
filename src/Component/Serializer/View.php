<?php

namespace App\Component\Serializer;

class View
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $serializationGroups;

    /**
     * @var int
     */
    private $status;

    /**
     * @param $data
     * @param array $serializationGroups
     * @param int $status
     */
    public function __construct($data, array $serializationGroups = [], int $status = 200)
    {
        $this->data = $data;
        $this->serializationGroups = $serializationGroups;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getSerializationGroups(): array
    {
        return $this->serializationGroups;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}

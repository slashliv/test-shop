<?php

namespace App\Output;

use JMS\Serializer\Annotation as JMS;

class ErrorsOutput
{
    /**
     * @var bool
     *
     * @JMS\SerializedName("success")
     * @JMS\Type("boolean")
     */
    private $success;

    /**
     * @var string
     *
     * @JMS\SerializedName("errors")
     * @JMS\Type("array")
     */
    private $errors;

    /**
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        $this->success = false;
        $this->errors = $errors;
    }
}

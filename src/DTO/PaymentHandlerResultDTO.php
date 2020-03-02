<?php

namespace App\DTO;

class PaymentHandlerResultDTO
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var array
     */
    private $errors;

    public function __construct()
    {
    }
}

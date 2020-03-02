<?php

namespace App\Component\Kernel;

use Symfony\Component\HttpFoundation\Request;

interface RequestStorageInterface
{
    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void;

    /**
     * @return Request
     */
    public function getRequest(): Request;
}

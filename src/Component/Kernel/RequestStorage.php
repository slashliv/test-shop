<?php

namespace App\Component\Kernel;

use Symfony\Component\HttpFoundation\Request;

class RequestStorage implements RequestStorageInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}

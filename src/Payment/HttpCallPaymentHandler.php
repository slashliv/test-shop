<?php

namespace App\Payment;

use App\Entity\Order;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HttpCallPaymentHandler implements PaymentHandlerInterface
{
    const ERROR_RESPONSE = 'Bad response.';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $url;

    /**
     * @param ClientInterface $httpClient
     * @param string $url
     */
    public function __construct(
        ClientInterface $httpClient,
        string $url
    ) {
        $this->httpClient = $httpClient;
        $this->url = $url;
    }

    /**
     * @param Order $order
     * @param PaymentInterface $payment
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function handle(Order $order, PaymentInterface $payment): array
    {
        if (200 !== $this->makeRequest()->getStatusCode()) {
            return [self::ERROR_RESPONSE];
        }

        return [];
    }

    /**
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    private function makeRequest(): ResponseInterface
    {
        try {
            return $this->httpClient->request(
                'GET',
                $this->url
            );
        } catch (BadResponseException $exception) {
            if (null !== $exception->getResponse()) {
                return  $exception->getResponse();
            }


            throw $exception;
        }
    }
}

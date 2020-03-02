<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param Request $request
     * @param string $inputClassName
     *
     * @return mixed
     */
    protected function getInput(Request $request, string $inputClassName)
    {
        return $this->getSerializer()->deserialize($request->getContent(), $inputClassName, 'json');
    }

    /**
     * @return SerializerInterface
     */
    protected function getSerializer(): SerializerInterface
    {
        return $this->container->get('serializer');
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->container->get('entity_manager');
    }

    /**
     * @param $data
     * @param array $groups
     * @param int $status
     *
     * @return JsonResponse
     */
    protected function sendOutput($data, array $groups = [], int $status = 200)
    {
        $context = null;
        if (!empty($groups)) {
            $context = new SerializationContext();
            $context->setGroups($groups);
        }

        return JsonResponse::fromJsonString(
            $this->getSerializer()->serialize($data, 'json', $context),
            $status
        );
    }
}

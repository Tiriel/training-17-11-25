<?php

namespace App\Serializer\Handler;

use App\Entity\EntityInterface;

class CircularReferenceHandler
{
    public function __invoke(object $object, ?string $format = null, array $context = [])
    {
        if (!$object instanceof EntityInterface) {
            return null;
        }

        return $object->getId();
    }
}

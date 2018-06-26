<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Stock;

class Serializer
{
    private $serializer;

    /**
     * Serializer constructor.
     * @param \Symfony\Component\Serializer\Serializer $serializer
     */
    public function __construct(\Symfony\Component\Serializer\Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $items
     * @return array
     * @throws \Exception
     */
    public function getObjectsArray(array $items): array
    {
        $arrayOfObjects = [];

        foreach ($items as $item) {
            try {
                $object = $this->serializer->deserialize(json_encode($item), Stock::class, 'json');
                array_push($arrayOfObjects, $object);
            } catch (\Exception $exception) {
                throw $exception;
            }
        }

        return $arrayOfObjects;
    }
}
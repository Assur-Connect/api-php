<?php

namespace AssurConnect\Api\Resources\Response;

class BaseResource
{
    public static function hydrate(array $result, string $resourceResponseClass = null)
    {
        if ($resourceResponseClass !== null) {
            $resource = new $resourceResponseClass();
            foreach ($result as $key => $value) {
                $property = lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key))));

                $method = 'bind' . ucfirst($property);
                if (method_exists($resource, $method)) {
                    $resource->$method($value);
                } else {
                    $resource->{$property} = $value;
                }
            }

            return $resource;
        }

        return $result;
    }
}

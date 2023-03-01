<?php

namespace JMWD\Testing\Unit\JsonApi;

use Illuminate\Support\Str;
use JMWD\Testing\TestCase;

abstract class JsonApiTestCase extends TestCase
{
    /**
     * @var string $entityClass
     */
    protected string $entityClass;

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @return array
     */
    protected function resolveJsonApiUtilities(): array
    {
        $entityClass = $this->getEntityClass();
        $explodedEntityClass = explode("\\", $entityClass);
        $camelCaseEntityName = end($explodedEntityClass);
        $kebabEntityName = Str::kebab($camelCaseEntityName);
        $resourceTypeName = Str::plural($kebabEntityName);

        $resourceTypes = config('json-api.resourceTypes');
        $type = $resourceTypes[$resourceTypeName];

        if (empty($type)) {
            $this->fail("Can't find the adapter for '{$entityClass}'.");
        }

        return $type;
    }
}

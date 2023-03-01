<?php

namespace JMWD\Testing\Unit\JsonApi;

use App\Doctrine\Contracts\Entity;
use JsonApiPhp\JsonApi\Error;
use ReflectionClass;
use JMWD\Testing\TestCase;

abstract class AbstractExceptionTest extends TestCase
{
    public function testException()
    {
        $method = 'getName';
        $entity = Entity::class;

        $exception = $this->buildException($method, $entity);

        $this->assertEquals(
            "$method() doesn't exist on {$entity}.",
            $exception->getMessage()
        );
    }

    /**
     * @param array $exceptionArgs
     * @param string $title
     * @param int $status
     * @param string $message
     *
     * @return void
     */
    public function runGetJsonApiErrorsTest(array $exceptionArgs, string $title, int $status, string $message): void
    {
        $exception = $this->buildException(...$exceptionArgs);
        $jsonApiErrors = $exception->getJsonApiErrors();

        /** @var Error $jsonApiError */
        $jsonApiError = reset($jsonApiErrors);

        $this->assertInstanceOf(Error::class, $jsonApiError);

        $reflection = new ReflectionClass($jsonApiError);
        $errorProperty = $reflection->getProperty('error');
        $error = $errorProperty->getValue($jsonApiError);

        $this->assertIsObject($error);
        $this->assertTrue(property_exists($error, 'title'));
        $this->assertTrue(property_exists($error, 'status'));
        $this->assertTrue(property_exists($error, 'detail'));

        $this->assertEquals($title, $error->title);
        $this->assertEquals($status, $error->status);
        $this->assertEquals($message, $error->detail);
    }

    /**
     * @param ...$args
     *
     * @return mixed
     */
    abstract public function buildException(...$args): mixed;
}

<?php

namespace JMWD\Testing\Unit\JsonApi;

use Illuminate\Support\Str;
use JMWD\JsonApi\Response\Schema;
use Tobyz\JsonApiServer\Schema\Attribute;
use Tobyz\JsonApiServer\Schema\Field;
use Tobyz\JsonApiServer\Schema\HasMany;
use Tobyz\JsonApiServer\Schema\HasOne;
use Tobyz\JsonApiServer\Schema\Relationship;
use Tobyz\JsonApiServer\Schema\Type;

abstract class SchemaTestCase extends JsonApiTestCase
{
    /**
     * @return void
     */
    public function testSchema(): void
    {
        $type = new Type();
        $this->buildSchema()->schema($type);

        $fieldsFromSchema = $type->getFields();
        $countOfFields = count($fieldsFromSchema);
        $matchedFields = [];

        $fieldsFromTest = $this->schema();

        /** @var Attribute $attribute */
        foreach ($fieldsFromSchema as $fieldFromSchema) {
            $title = $fieldFromSchema->getName();

            if (array_key_exists($title, $fieldsFromTest)) {
                $fieldFromTest = $fieldsFromTest[$title];

                $matchedFields[] = $title;

                if ($fieldFromSchema instanceof Attribute) {
                    $this->runAttributeAssertions($fieldFromSchema, $fieldFromTest, $title);
                }

                if ($fieldFromSchema instanceof HasMany) {
                    $this->runHasManyAssertions($fieldFromSchema, $fieldFromTest, $title);
                }

                if ($fieldFromSchema instanceof HasOne) {
                    $this->runHasOneAssertions($fieldFromSchema, $fieldFromTest, $title);
                }
            }
        }

        $stack = debug_backtrace();
        $recentLine = reset($stack);
        $testName = get_class($recentLine['object']);

        $this->assertCount($countOfFields, $matchedFields, "Failure in `{$testName}::testSchema()}`");
    }

    protected function runAttributeAssertions(Attribute $attribute, array $field, string $title): void
    {
        $this->assertWritable($attribute, $field, $title);
        $this->assertWritableOnce($attribute, $field, $title);
        $this->assertFilterable($attribute, $field, $title);
        $this->assertVisible($attribute, $field, $title);
        $this->assertSortable($attribute, $field, $title);
    }

    protected function runHasManyAssertions(HasMany $hasMany, array $field, string $title): void
    {
        $this->assertProperty($hasMany, $field, $title);
        $this->assertWritable($hasMany, $field, $title);
        $this->assertWritableOnce($hasMany, $field, $title);
        $this->assertFilterable($hasMany, $field, $title);
        $this->assertVisible($hasMany, $field, $title);
        $this->assertLinkage($hasMany, $field, $title);
        $this->assertIncludable($hasMany, $field, $title);
        $this->assertMeta($hasMany, $field, $title);
    }

    protected function runHasOneAssertions(HasOne $hasOne, array $field, string $title): void
    {
        $this->assertProperty($hasOne, $field, $title);
        $this->assertWritable($hasOne, $field, $title);
        $this->assertWritableOnce($hasOne, $field, $title);
        $this->assertFilterable($hasOne, $field, $title);
        $this->assertVisible($hasOne, $field, $title);
        $this->assertLinkage($hasOne, $field, $title);
        $this->assertIncludable($hasOne, $field, $title);
        $this->assertMeta($hasOne, $field, $title);
    }

    /**
     * @param Attribute $fieldFromSchema
     * @param array     $fieldFromTest
     * @param string    $title
     *
     * @return void
     */
    protected function assertProperty(Field $fieldFromSchema, array $fieldFromTest, string $title): void
    {
        $this->assertAttributeProperty($fieldFromSchema, $fieldFromTest, $title, 'property', null);
    }

    /**
     * @param Attribute $fieldFromSchema
     * @param array     $fieldFromTest
     * @param string    $title
     *
     * @return void
     */
    protected function assertWritable(Field $fieldFromSchema, array $fieldFromTest, string $title): void
    {
        $this->assertAttributeProperty($fieldFromSchema, $fieldFromTest, $title, 'writable', false);
    }

    /**
     * @param Attribute $fieldFromSchema
     * @param array     $fieldFromTest
     * @param string    $title
     *
     * @return void
     */
    protected function assertWritableOnce(Field $fieldFromSchema, array $fieldFromTest, string $title): void
    {
        $this->assertAttributeProperty($fieldFromSchema, $fieldFromTest, $title, 'writableOnce', false, 'is');
    }

    /**
     * @param Attribute $fieldFromSchema
     * @param array     $fieldFromTest
     * @param string    $title
     *
     * @return void
     */
    protected function assertFilterable(Field $fieldFromSchema, array $fieldFromTest, string $title): void
    {
        $this->assertAttributeProperty($fieldFromSchema, $fieldFromTest, $title, 'filterable', false);
    }

    /**
     * @param Attribute $fieldFromSchema
     * @param array     $fieldFromTest
     * @param string    $title
     *
     * @return void
     */
    protected function assertVisible(Field $fieldFromSchema, array $fieldFromTest, string $title): void
    {
        $this->assertAttributeProperty($fieldFromSchema, $fieldFromTest, $title, 'visible', true);
    }

    /**
     * @param Attribute $attribute
     * @param array     $field
     * @param string    $title
     *
     * @return void
     */
    protected function assertSortable(Attribute $attribute, array $field, string $title): void
    {
        $this->assertAttributeProperty($attribute, $field, $title, 'sortable', false);
    }

    /**
     * @param Relationship $relationship
     * @param array        $fieldFromTest
     * @param string       $title
     *
     * @return void
     */
    protected function assertMeta(Relationship $relationship, array $fieldFromTest, string $title): void
    {
        $this->assertAttributeProperty($relationship, $fieldFromTest, $title, 'meta', []);
    }

    /**
     * @param Relationship $relationship
     * @param array        $field
     * @param string       $title
     *
     * @return void
     */
    protected function assertLinkage(Relationship $relationship, array $field, string $title): void
    {
        $this->assertAttributeProperty($relationship, $field, $title, 'linkage', false, 'has');
    }

    /**
     * @param Relationship $relationship
     * @param array        $field
     * @param string       $title
     *
     * @return void
     */
    protected function assertIncludable(Relationship $relationship, array $field, string $title): void
    {
        $this->assertAttributeProperty($relationship, $field, $title, 'includable', false, 'is');
    }

    /**
     * @param Attribute       $fieldFromSchema
     * @param array           $fieldFromTest
     * @param string          $title
     * @param string          $property
     * @param bool|array|null $value
     * @param string          $prefix
     *
     * @return void
     */
    protected function assertAttributeProperty(
        Field $fieldFromSchema,
        array $fieldFromTest,
        string $title,
        string $property,
        bool|array|null $value,
        string $prefix = 'get'
    ): void {
        $getterWithSpace = implode(' ', [$prefix, $property]);
        $getterCamelCase = Str::camel($getterWithSpace);

        if (array_key_exists($property, $fieldFromTest)) {
            $value = $fieldFromTest[$property];
        }

        $message = "'{$title}': mismatch for '{$property}'";

        if (empty($value)) {
            $message .= ". Note: The Schema changes aren't reflected within the test.";
        } else {
            $message .= ". Note: The test changes aren't reflected within the Schema.";
        }

        $this->assertEquals($value, $fieldFromSchema->$getterCamelCase(), $message);
    }

    /**
     * @return array[]
     */
    abstract public function schema(): array;

    /**
     * @return string
     */
    protected function getSchemaName(): string
    {
        $adapterSchemaArray = $this->resolveJsonApiUtilities();
        return reset($adapterSchemaArray);
    }

    /**
     * @return Schema
     */
    protected function buildSchema(): Schema
    {
        return app($this->getSchemaName());
    }
}

<?php


class DropIndexDDLTest extends Codeception\Test\Unit
{
    /**
     * @return void
     */
    public function test_ddl_when_index_is_unique(): void
    {
        $platform = new \FondOf\Propel\Generator\Platform\PgsqlPlatform();
        $index = new \Propel\Generator\Model\Unique();
        $index->setName('foo-bar');
        $ddl = $platform->getDropIndexDDL($index);

        $this->assertEquals('
DROP INDEX "foo-bar";
', $ddl);
    }

    /**
     * @return void
     */
    public function test_ddl_when_index_is_not_unique(): void
    {
        $platform = new \FondOf\Propel\Generator\Platform\PgsqlPlatform();
        $mock = $this->getMockBuilder('\Propel\Generator\Model\Index');
        $index = $mock->setMethods(['getFQName'])->getMock();
        $index->method('getFQName')->willReturn('foo-bar');
        $ddl = $platform->getDropIndexDDL($index);

        $this->assertEquals('
DROP INDEX "foo-bar";
', $ddl);
    }
}

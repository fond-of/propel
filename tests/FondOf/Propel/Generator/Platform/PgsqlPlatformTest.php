<?php

namespace FondOf\Propel\Generator\Platform;

use Codeception\Test\Unit;
use Propel\Generator\Model\Column;
use Propel\Generator\Model\Index;
use Propel\Generator\Model\Table;

class PgsqlPlatformTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Propel\Generator\Model\Index
     */
    protected $indexMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Propel\Generator\Model\Table
     */
    protected $tableMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Propel\Generator\Model\Column
     */
    protected $columnMock;

    /**
     * @var \FondOf\Propel\Generator\Platform\PgsqlPlatform
     */
    protected $pgsqlPlatform;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $indexName;

    /**
     * @var string
     */
    protected $columnName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->indexMock = $this->getMockBuilder(Index::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->tableMock = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->columnMock = $this->getMockBuilder(Column::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->tableName = 'table';
        $this->indexName = 'index';
        $this->columnName = 'column';

        $this->pgsqlPlatform = new PgsqlPlatform();
    }

    /**
     * @return void
     */
    public function testGetAddIndex(): void
    {
        $pattern = "
CREATE INDEX \"%s\" ON \"%s\" (\"%s\");
";

        $this->indexMock->expects($this->atLeastOnce())
            ->method('isUnique')
            ->willReturn(false);

        $this->indexMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->indexName);

        $this->indexMock->expects($this->atLeastOnce())
            ->method('getTable')
            ->willReturn($this->tableMock);

        $this->tableMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->tableName);

        $this->indexMock->expects($this->atLeastOnce())
            ->method('getColumnObjects')
            ->willReturn([$this->columnMock]);

        $this->columnMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->columnName);

        $addIndexDDL = $this->pgsqlPlatform->getAddIndexDDL($this->indexMock);

        $this->assertEquals(
            sprintf(
                $pattern,
                $this->indexName,
                $this->tableName,
                $this->columnName
            ),
            $addIndexDDL
        );
    }

    /**
     * @return void
     */
    public function testGetAddIndexWithUniqueFlag(): void
    {
        $pattern = "
ALTER TABLE \"%s\" ADD CONSTRAINT \"%s\" UNIQUE (\"%s\");
";

        $this->indexMock->expects($this->atLeastOnce())
            ->method('isUnique')
            ->willReturn(true);

        $this->indexMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->indexName);

        $this->indexMock->expects($this->atLeastOnce())
            ->method('getTable')
            ->willReturn($this->tableMock);

        $this->tableMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->tableName);

        $this->indexMock->expects($this->atLeastOnce())
            ->method('getColumnObjects')
            ->willReturn([$this->columnMock]);

        $this->columnMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->columnName);

        $addIndexDDL = $this->pgsqlPlatform->getAddIndexDDL($this->indexMock);

        $this->assertEquals(
            sprintf(
                $pattern,
                $this->tableName,
                $this->indexName,
                $this->columnName
            ),
            $addIndexDDL
        );
    }
}

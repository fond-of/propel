<?php

namespace FondOf\Propel\Generator\Platform;

use Propel\Generator\Model\Index;
use Propel\Generator\Platform\PgsqlPlatform as PropelPgsqlPlatform;

class PgsqlPlatform extends PropelPgsqlPlatform
{
    /**
     * Returns the DDL SQL to add an Index.
     *
     * @param \Propel\Generator\Model\Index $index
     *
     * @return string
     */
    public function getAddIndexDDL(Index $index): string
    {
        if (!$index->isUnique()) {
            return parent::getAddIndexDDL($index);
        }

        $pattern = "
ALTER TABLE %s ADD CONSTRAINT %s UNIQUE (%s);
";

        return sprintf(
            $pattern,
            $this->quoteIdentifier($index->getTable()->getName()),
            $this->quoteIdentifier($index->getName()),
            $this->getColumnListDDL($index->getColumnObjects())
        );
    }
}

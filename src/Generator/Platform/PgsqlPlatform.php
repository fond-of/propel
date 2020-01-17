<?php

namespace FondOf\Propel\Generator\Platform;

use Propel\Generator\Model\Index;
use Propel\Generator\Model\Unique;
use Propel\Generator\Platform\PgsqlPlatform as PropelPgsqlPlatform;

class PgsqlPlatform extends PropelPgsqlPlatform
{
    const DROP_INDEX_DDL_PATTERN = <<<EOT

DROP INDEX %s;

EOT;

   /**
    * Overrides the implementation from PropelPsqlPlatform
    *
    * @param \Propel\Generator\Model\Index
    *
    * @return string
    */
    public function getDropIndexDDL(Index $index): string
    {
        if ($index instanceof Unique) {
            $pattern = static::DROP_INDEX_DDL_PATTERN;

            return sprintf(
                $pattern,
                $this->quoteIdentifier($index->getName())
            );
        }

        return parent::getDropIndexDDL($index);
    }
}

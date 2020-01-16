<?php

namespace FondOf\Propel\Generator\Platform;

use Propel\Generator\Model\Index;
use Propel\Generator\Model\Unique;
use Propel\Generator\Platform\PgsqlPlatform as PropelPgsqlPlatform;

class PgsqlPlatform extends PropelPgsqlPlatform
{
   /**
    * Overrides the implementation from PropelPsqlPlatform
    *
    * @param \Propel\Generator\Model\Index
    *
    * @return string
    */
    public function getDropIndexDDL(Index $index)
    {
        if ($index instanceof Unique) {
            $pattern = "DROP INDEX %s.%s;";

            return sprintf(
                $pattern,
                $this->quoteIdentifier($index->getTable()->getName()),
                $this->quoteIdentifier($index->getName())
            );
        }

        return parent::getDropIndexDDL($index);
    }
}

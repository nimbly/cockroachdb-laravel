<?php

namespace Cockroach;

use Doctrine\DBAL\Driver\PDOPgSql\Driver as DoctrineDriver;
use Cockroach\Builder\CockroachBuilder;
use Cockroach\Grammar\Query\CockroachGrammar as QueryGrammar;
use Cockroach\Grammar\Schema\CockroachGrammar as SchemaGrammar;
use Illuminate\Database\Connection;
use Cockroach\Processor\CockroachProcessor;

class CockroachConnection extends Connection
{
    /**
     * Get the default query grammar instance.
     *
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return CockroachBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new CockroachBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return CockroachProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new CockroachProcessor();
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOPgSql\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver;
    }
}

<?php

namespace App\Parsers;
use Goutte\Client;

/**
 * Interface Parser - Specifc interface for all Parser objects
 * @package App\Parsers
 */
Interface Parser
{
    /**
     * @return mixed
     */
    public function getParsedData();
}
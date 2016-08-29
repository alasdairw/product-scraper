<?php

namespace App\Parsers;
use Goutte\Client;

/**
 * Base interace definition for Parsers
 */
Interface Parser
{
    public function getParsedData();
}
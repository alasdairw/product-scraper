<?php

namespace App\Parsers;
use Goutte\Client;

/**
 * Base clase for handling parsing - all universal functions to make requests/get base data.
 */
Interface Parser
{
    public function getParsedData();
}
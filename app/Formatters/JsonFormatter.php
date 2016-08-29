<?php
namespace App\Formatters;
use App\Parsers\Parser;
interface Formatter
{
    public function getFormattedOutput();
}

class JsonFormatter implements Formatter
{
    /**
     * Creates new JSONFormatter
     * @param Parser $parser Implementation of Parser Interface, with methoer getParsedData returning array (or objects)
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Get JSON Pretty Print formatted output
     * @return string JSON-encoded string of result of Parser::getParsedData, formatted for readability
     */
    public function getFormattedOutput()
    {
        return json_encode($this->parser->getParsedData(),JSON_PRETTY_PRINT);
    }

}
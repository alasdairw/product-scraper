<?php
namespace App\Formatters;
use App\Parsers\Parser;
interface Formatter
{
    public function getFormattedOutput();
}

class JsonFormatter implements Formatter
{
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function getFormattedOutput()
    {
        return json_encode($this->parser->getParsedData(),JSON_PRETTY_PRINT);
    }

}
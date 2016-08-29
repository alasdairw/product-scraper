<?php
namespace App\Formatters;
interface Formatter
{
    public function getFormattedOutput();
}

class JsonFormatter implements Formatter
{
    public function __construct(\Parser $parser)
    {
        $this->parser = $parser;
    }

    private function format(array $array)
    {
        return json_encode($array,true);
    }

    public function getFormattedOutput()
    {
        return json_encode($this->parser->getParsedData(),true);
    }

}
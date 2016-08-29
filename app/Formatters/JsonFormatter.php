<?php
namespace App\Formatters;
interface Formatter
{
    public function format(array $array);    
}

class JsonFormatter implements Formatter
{
    public function format(array $array)
    {
        return json_encode($array,true);
    }

}
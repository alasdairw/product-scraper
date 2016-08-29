<?php 
use PHPUnit\Framework\TestCase;
use App\Formatters\JsonFormatter;

class JSONParserTest extends TestCase
{
    public function testFormat()
    {
        $array = array('foo' => 'bar');
        $formatter = new JsonFormatter();
        $output = $formatter->format($array);
        $this->assertJson($output);
        $data = json_decode($output,true);
    }
}
<?php 
namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Formatters\JsonFormatter;
use App\Parsers\IndexParser;
use Mockery;

class JSONFormatterTest extends TestCase
{
    public function setUp()
    {
        $parser = Mockery::mock('Parser');
        $parser->shouldReceive('getParsedData')->once()->andReturn(array('results' => [array('title'=>'Some title')],'total'=>'12.00'));
        $this->formatter = new JsonFormatter($parser);
    }

    public function testGetFormattedOutput()
    {
        $output = $this->formatter->getFormattedOutput();
        
        $this->assertJson($output);
        $data = json_decode($output,true);
        $this->assertArrayHasKey('results',$data);
        $this->assertArrayHasKey('total',$data);
        $this->assertArrayHasKey('title',$data['results'][0]);
    }
}
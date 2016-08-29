<?php 
namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Formatters\JsonFormatter;
use App\Parsers\IndexParser;
use Mockery;

/**
 * Class JSONFormatterTest
 * @package App\Tests
 */
class JSONFormatterTest extends TestCase
{

    /**
     *  Mock an IndexParser
     */
    public function setUp()
    {
        $parser = Mockery::mock(IndexParser::class);
        $parser->shouldReceive('getParsedData')->once()->andReturn(array('results' => [array('title'=>'Some title')],'total'=>'12.00'));
        $this->formatter = new JsonFormatter($parser);
    }

    /**
     *  Test thes the final JSON to ensure it meets roughly what's expected - A
     *  results array with at least one element that containst a title, and
     *  a total figure, that match what was passed in as a mock.
     */
    public function testGetFormattedOutput()
    {
        $output = $this->formatter->getFormattedOutput();
        
        $this->assertJson($output);
        $data = json_decode($output,true);
        $this->assertArrayHasKey('results',$data);
        $this->assertArrayHasKey('total',$data);
        $this->assertEquals('12.00',$data['total']);
        $this->assertArrayHasKey('title',$data['results'][0]);
        $this->assertEquals('Some title',$data['results'][0]['title']);
        
    }
}
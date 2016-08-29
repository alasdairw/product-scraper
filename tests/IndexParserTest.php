<?php
namespace App\Tests;
use Mockery;
use PHPUnit\Framework\TestCase;
use App\Parsers\IndexParser;
use Symfony\Component\DomCrawler\Crawler;
use App\Crawlers\JSProductCrawler;

/**
 * Simple tests for the Base parser class
 * @package App\Tests
 */
class IndexParserTest extends TestCase
{
    

    /**
     * Set up a mock index page
     * @return void
     */
    public function setUp()
    {
        $html = <<<EOD
<html>
    <head></head>
    <body>
        <div class="productInner">
            <div class="productInfoWrapper">
                <div class="productInfo">
                    <h3>
                        <a href="http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html">
                            Sainsbury's Apricot Ripe &amp; Ready x5
                            <img src="http://c2.sainsburys.co.uk/wcsstore7.11.1.161/SainsburysStorefrontAssetStore/wcassets/product_images/media_7572754_M.jpg" alt="">
                        </a>
                    </h3>
                                
                </div>
            </div>
            <div class="addToTrolleytabBox">
                <div class="addToTrolleytabContainer addItemBorderTop">
                    <div class="pricingAndTrolleyOptions">  
                        <div class="priceTab activeContainer priceTabContainer" id="addItem_149117">    
                            <div class="pricing">
                                <p class="pricePerUnit">
                                    &pound3.50<abbr title="per">/</abbr><abbr title="unit"><span class="pricePerUnitUnit">unit</span></abbr>
                                </p>     
                            </div>  
                        </div>    
                    </div>  
                </div>  
            </div>
        </div>
    </body>
</html>
EOD;

        $crawler = Mockery::mock(JSProductCrawler::class);
        $crawler->shouldReceive('getURL')
                ->once()
                ->andReturn(new Crawler($html,'http://localhost'));
        $this->parser = new IndexParser($crawler);
    }

    /**
     * Test the specific GET request function
     * @return void
     */
    public function testGetParsedData()
    {
        $response = $this->parser->getParsedData();
        $this->assertArrayHasKey('results',$response);
        $this->assertArrayHasKey('total',$response);
    }

    /**
     * Test the data that is extracted from the products
     * Since I'm not using a proper mock for this, I'm going to rely on testGetProducts passing for now.
     * @return void
     */
    public function testExtractProductData()
    {
        $product = $this->parser->markup->filter('.productInner')->eq(0);
        $output = $this->parser->extractProductData($product);
        $this->assertArrayHasKey('title',$output);
        $this->assertEquals('Sainsbury\'s Apricot Ripe & Ready x5',$output['title']);
        $this->assertArrayHasKey('size',$output);
        $this->assertArrayHasKey('unit_price',$output);
        $this->assertEquals(3.5,$output['unit_price']);
        $this->assertArrayHasKey('description',$output);
    }

    /**
     * Test that the getTitle method returns a string of at least 1 character length
     * If and when we have a proper mock, check for a known value
     * @return void
     */
    public function testGetTitle()
    {
        $output = $this->parser->getTitle($this->parser->markup->filter('.productInner')->eq(0));
        $this->assertInternalType('string',$output);
        $this->assertGreaterThanOrEqual(1,strlen($output));
        $this->assertEquals('Sainsbury\'s Apricot Ripe & Ready x5',$output);
    }

    /**
     * Test that the result of getUnitPrice is a a float
     * @return void
     */
    public function testGetUnitPrice()
    {
        $output = $this->parser->getUnitPrice($this->parser->markup->filter('.productInner')->eq(0));
        $this->assertInternalType('float',$output);
        $this->assertEquals(3.5,$output);
    }

    /**
     * Test the output of the getDescription and Size method - this is going to wind up making
     * an external http call thanks to the markup above, but I thing that adding a local http
     * server to this just for the sake of one test is overkill.
     * @return voice
     */
    public function testGetDescriptionAndSize()
    {
        $output = $this->parser->getDescriptionAndSize($this->parser->markup->filter('.productInner')->eq(0));
        $this->assertArrayHasKey('size',$output);
        $this->assertArrayHasKey('description',$output);
    }
}
<?php 
namespace App\Crawlers;
use Goutte\Client;

/**
 * Interface JSCrawler - specify behaviours that can be relied in Crawlers.
 * @package App\Crawlers
 */
interface JSCrawler
{
    /**
     * @return mixed
     */
    public function getURL();

    /**
     * @return mixed
     */
    public function getSize();
}

/**
 * Class JSProductCrawler - really just a simple means for managing what we need from Goutte
 * @package App\Crawlers
 */
class JSProductCrawler implements JSCrawler
{
    /**
     * Instantiates Goutte Client as $this->client
     * @param $url string URL to parse.  (Defaulting to base test URL for ease.)
     * @return void
     */
    public function __construct($url='http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html')
    {
        $this->client = new Client();
        $this->url = $url;
    }

    /**
     * Performa a GET request to the URL the Crawler was instantiated with.
     * @return Crawler   Symfony\Component\DomCrawler\Crawler DOM Crawler object
     * @todo: should we handle exceptions here if ::request throws and error
     */
    public function getURL()
    {
        return $this->request($this->url);
    }

    /**
     * Get the size in bytes of the request
     * @return integer size of request in bytes
     */
    public function getSize()
    {
        return $this->client->getInternalResponse()->getHeader('Content-Length');
    }

    /**
     * Perform a Goutte HTTP request to specified URL with specified method, default GET
     * @param  string $url    URL to request
     * @param  string $method HTTP method to use
     * @return Crawler        Symfony\Component\DomCrawler\Crawler DOM Crawler object
     * @todo: means of passing in parameters for non-GET requests?
     */
    private function request($url='', $method = 'GET')
    {
        return $this->client->request(strtoupper($method), $url);
    }
}
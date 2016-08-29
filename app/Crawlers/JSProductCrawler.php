<?php 
namespace App\Crawlers;
use Goutte\Client;

interface JSCrawler
{
    public function getURL();
}

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
     * Performa a GET request to the specified URL
     * @param  string $url Url to fetch.  Default is index page for test.
     * @return Crawler   Symfony\Component\DomCrawler\Crawler DOM Crawler object
     * @todo: should we handle exceptions here if ::request throws and error
     */
    public function getURL()
    {
        return $this->request($this->url);
    }

    /**
     * Get the size in bytes of the request
     * @return [type] [description]
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
     * @todo: means of passing in parameters for non-GET requests
     */
    private function request($url='', $method = 'GET')
    {
        try 
        {
            return $this->client->request(strtoupper($method), $url);
        } 
        catch (ConnectException $error) 
        {
            throw $error;
        }
    }
}
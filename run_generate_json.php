<?php

require __DIR__ . '/bootstrap.php';
use App\Formatters\JsonFormatter;

$crawler = new JSProductCrawer('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html');
$parser = new IndexParser($crawler);


$output = new JsonFormatter();

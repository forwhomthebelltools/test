<?php

require 'vendor/autoload.php';
use Goutte\Client;

$first = $_POST['firstSite'];
$second = $_POST['secondSite'];

echo "First site is " . $first;
echo "<br>";
echo "Second site is " . $second;
echo "<br>";


function findLinks($site1, $site2)
{
	$links = array();
    $result = array();
    $client = new Client();
    $crawler = $client->request('GET', $site1);
    $result = $crawler->filter('a')->each(function ($node) {
        if ($node->attr('href') != '#') {
        	return $node->attr('href');	
        }
    });

    $links[0] = $result;

    unset($result);
    $crawler = $client->request('GET', $site2);
    $result = $crawler->filter('a')->each(function ($node) {
        if ($node->attr('href') != '#') {
        	return $node->attr('href');	
        }
        
    });

    $links[1] = $result;

    return $links;

}

$links = findLinks($first, $second);

echo gettype($links);



?>
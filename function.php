<?php

require 'vendor/autoload.php';
use Goutte\Client;

$first = $_POST['firstSite'];
$second = $_POST['secondSite'];

echo "First site is " . $first;
echo "<br>";
echo "Second site is " . $second;
echo "<br>";


$client = new Client();
$crawler = $client->request('GET', $first);
$result = $crawler->filter('a')->each(function ($node) {
	echo $node->attr('href') . "<br>";	
});

?>
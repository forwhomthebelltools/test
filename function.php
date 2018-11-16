<?php


require 'vendor/autoload.php';
use Goutte\Client;


$first = $_POST['firstSite'];
$second = $_POST['secondSite'];


echo "First site is " . $first;
echo "<br>";
echo "Second site is " . $second;
echo "<br>";


$links = findLinks($first, $second);


$urls1 = array();
foreach ($links[0] as $link) {
    if (isValid($link)) {
        $urls1[] = findOneDepthLinks($link);
        echo $link . "<br>";
    }
}




function findLinks($site1, $site2)
{
    $links = array();
    $client = new Client();
    $crawler = $client->request('GET', $site1);
    $result = $crawler->filter('a')->each(function ($node) {
        if (isValid($node->attr('href'))) {
            return $node->attr('href');    
        }
        	
        
    });

    $links[0] = $result;

    $crawler = $client->request('GET', $site2);
    $result = $crawler->filter('a')->each(function ($node) {
        if (isValid($node->attr('href'))) {
            return $node->attr('href');    
        }
         
        
    });

    $links[1] = $result;

    return $links;

}


function findOneDepthLinks($link)
{
    $result = array();
    $client = new Client();
    $crawler = $client->request('GET', $link);
    $result = $crawler->filter('a')->each(function ($node) {
        if (isValid($node->attr('href'))) {
            return $node->attr('href');    
        }
             
    });

    return $result;
}


function isValid($link)
{
        if (!preg_match("/\b(?:(?:https?|http?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$link)) {
          return false;
        }

        return true;

}


?>
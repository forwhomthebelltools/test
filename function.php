<?php


require 'vendor/autoload.php';
use Goutte\Client;


$first = $_POST['firstSite'];
$second = $_POST['secondSite'];


echo "First site is " . $first;
echo "<br>";
echo "Second site is " . $second;
echo "<br>";


$links = array();
$links[0] = findLinks($first);
$links[1] = findLinks($second);


$arrayTot = array();
foreach ($links[0] as $link) {
    if(isValid($link)) {
        $arrayTot[] = findLinks($link);    
    }
     
}


$arrayTot2 = array();
foreach ($links[1] as $link) {
    $arrayTot2[] = findLinks($link); 
}

print_r($arrayTot);

print_r($arrayTot2);



//$array = getMaxSim($firstArray,$secondArray);




// //print all the max similarities
// $file = fopen('contacts.csv','w');
// foreach ($array as $sim) {
//     fputcsv($file, $sim);   
// }


// fclose($file);



//----------- FUNCTIONS -----------------//


//get the maximum similarity for relation
//one-to-many
function getMaxSim($array1,$array2) {
    $list = array();
    for ($i=0; $i<count($array1); $i++) {
        if ($array1[$i] == ''){
            continue;
        }
        $max = 0;
        for($j=0; $j<count($array2); $j++) {
            similar_text($array1[$i], $array2[$j], $perc);
            if ($max < $perc) {
                $max = $perc;
                $link = $array2[$j];
            }   
        }

    $maxSim = array($array1[$i] . ", " . $link . ", " . sprintf('%0.2f', $max) . "%");
    $list[] = $maxSim;      
    
    }   

    return $list;

}


function findLinks($site)
{
    
	$links = array();
    $client = new Client();
    $crawler = $client->request('GET', $site);
    $links = $crawler->filter('a')->each(function ($node) {
        if ($node->attr('href') != "#") {
            return $node->attr('href'); 
        }	
        
    });

    return $links;

}



//reg exp to find regular links
function isValid($link)
{
    if (!preg_match("/\b(?:(?:https?|http?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$link)) {
      return false;
    }

    return true;

}



?>
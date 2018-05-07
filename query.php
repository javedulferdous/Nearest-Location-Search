<html>
  <head>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css" />
    <script type="text/javascript" src="http://www.google.com/jsapi"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="./sparqlSearch.js"></script>
    <title>A Knowledgebase for the Nearest Location in Dhaka</title> 
  </head>
  <h1 style="text-align:center;">A Knowledgebase for the Nearest Location in Dhaka</h1>
<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("arc2-master/ARC2.php");

/* configuration */ 
$config = array(
  /* remote endpoint */
  'remote_store_endpoint' => 'http://localhost:3030/IWS/sparql',
);

/* instantiation */
$store = ARC2::getRemoteStore($config);

if ($iwsError = $store->getErrors())
    {
        echo "Something wrong with endpoint conection";
    }
	
$GLOBALS['prefix'] = "
    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
    PREFIX owl: <http://www.w3.org/2002/07/owl#> 
    PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
    PREFIX xsd: <http://www.w3.org/2001/XMLSchema#> 
    PREFIX ont: <http://www.semanticweb.org/jafra/ontologies/2018/4/IWSP#> 
";

function myQuery($key){
$query = $GLOBALS['prefix'] . 'SELECT DISTINCT ?Individual
		WHERE { 
		  ?ots rdfs:label ?Individual .
                  ?ots rdf:type ?ar .
		  ?ar rdfs:label "'.$key.'" .
                  FILTER( "'.$key.'" != ?Individual )
}
LIMIT 100';

$result = $GLOBALS['store']->query( $query, 'rows' );
var_dump($result);
}
?>
<form action="#" method="POST" style="text-align:center;">
  
  <input type="text" name="query"><br>
  <input type="submit" value="Submit">
</form>

<div class="data">
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	myQuery($_POST["query"]);
}
?>
</div>



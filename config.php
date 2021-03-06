<?php

#Error reporting
error_reporting(E_ALL ^ E_STRICT);

#Display errors?
ini_set('display_errors', '1');

#Mysql host, username and password.
$con = mysql_connect("localhost","root","");

#check connection to Mysql
if(!$con)
  die('Could not connect: ' . mysql_error());
    
#Timezone
date_default_timezone_set('Europe/Berlin');

#database to use
mysql_select_db("stocktest", $con) or die(mysql_error());;

#charset to use
mysql_set_charset('utf8');

#Allow to store big blobs
$query = ( 'SET @@global.max_allowed_packet = ' . 100 * 1024 * 1024 );
$result=mysql_query($query); 

#Todays date
$TODAY = date("Y-m-d");

#Allow script to run a long time to finish updates
set_time_limit(200);

#Dividend 1: Dividend at day based on quantity at day
#Dividend 2: Dividend every day based on last know interest on year basis. (Bank year).

#DOES NOT WORK YET, stockId over 1000 is type 3 and below 1000 is type 1,2
$stockProperties = 
  array(
    array('type'     => 1,
	      'name'     => 'Aktie',
		  'dividend' => 1),
		  
    array('type'     => 2,
	      'name'     => 'Fond',
		  'dividend' => 1),
		  
    array('type'     => 3,
	      'name'     => 'Räntebärande konto',
		  'dividend' => 2));
		  

#How many days to calculate intereset on.
$daysInBankYear = 360;

#Link to nordet, morningstar and avanza. Multidimensional array.
$fetch_nordnet = 
  array(
    array('stockID' => 2,
  	      'link'    => 'https://www.nordnet.se/mux/laddaner/historikLaddaner.ctl?isin=SE0000635401&country=Sverige'),
  ); 

$fetch_morningstar = 
  array( 
    array('stockID' => 5,
	      'link'    => 'http://morningstar.se/Funds/Quicktake/Overview.aspx?perfid=0P00005U1J&programid=0000000000'),
  ); 

$fetch_avanza = 
  array( 
    array('stockID' => 2,
	      'link'    => 'https://www.avanza.se/aza/aktieroptioner/kurslistor/aktie.jsp?orderbookId=216967'),
    ); 

?>

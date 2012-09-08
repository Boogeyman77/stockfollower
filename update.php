<?php
  $site="update";

include 'config.php';
include 'class/port.php';
include 'class/stock.php';
include 'class/index.php';
include 'class/sys.php';
include 'class/rss.php';
include 'class/update.php';



include 'pageTop.php'; 



if(!isset($_POST['up']) && !isset($_POST['sumV']) && !isset($_POST['sumD']) && !isset($_POST['updateRss'])) {
?>

<form name="update" action="./update.php" method="POST">
  <input type="checkbox" name="AVA" value="Bike" checked class="radio"/>Avanza<br />
  <input type="checkbox" name="MS" value="Bike" checked />Morningstar<br />
  <input type="checkbox" name="NN" value="Bike" checked />Nordnet<br />
  <input type="checkbox" name="OI" value="Bike" checked />OMX INDEX<br /><br />
  <input type="checkbox" name="sumD" value="Bike" checked />Summering Utdelning<br />
  <input type="checkbox" name="sumV" value="Bike" checked />Summering Värde<br />
  <br>
  <input type="checkbox" name="updateRss" value="Bike" checked />Pressmedelanden<br />
  <br>
  <input type="submit" name="up" value="Kör manuell uppdatering">
</form> 

<hr \>
<br>

<form name="update1" action="./update.php" method="POST">
  <input type="submit" name="sumD" value="Uppdatera tabell för utdelning">
</form> 

<br>
<form name="update2" action="./update.php" method="POST">
  <input type="submit" name="sumV" value="Uppdatera tabell för summa">
</form> 

<hr \>

<br>
<form name="updateRss" action="./update.php" method="POST">
  <input type="submit" name="updateRss" value="Uppdatera RSS">
</form> <!--
<hr \>

<br>
<br>
<form name="updateS" action="./update.php" method="POST">
  <input type="checkbox" name="dividend" value="Bike" checked />Kalkylera utdelningar direkt<br />
  <input type="checkbox" name="sum" value="Bike" checked />Kalkylera summa direkt<br />
  <input type="submit" value="Skicka">
</form> -->


<?php
} else {


if(isset($_POST['NN'])) {
  echo "NORDNET:"; 
  sys::flush_page();
  if(update::nordnet($fetch_nordnet))
    echo "<span style=\"color: green\"> OK</span>";
  echo '<br>';
}

if(isset($_POST['MS'])) {
  echo "MORNINGSTAR:";
  sys::flush_page();
  if(update::morningstar($fetch_morningstar)) 
    echo "<span style=\"color: green\"> OK</span>";
  echo '<br>';
}

if(isset($_POST['AVA'])) {
  echo "AVANZA:";
  sys::flush_page();
  if(update::avanza($fetch_avanza))
    echo "<span style=\"color: green\"> OK</span>";
  echo '<br>';
}

if(isset($_POST['OI'])) {
  ###Takes fetch from Database.
  echo "NASDAQ:";
  sys::flush_page();
  if(update::nasdaq($TODAY))
    echo "<span style=\"color: green\"> OK</span>";
  else 
    echo "<span style=\"color: red\"> EJ OK</span>";
  echo '<br>';
}

if(isset($_POST['sumD'])) {
  echo "Sumering udelning:";
  sys::flush_page();
  if(port::cacheDividendSum())
    echo "<span style=\"color: green\"> OK</span>";
  echo '<br>';
}

if(isset($_POST['sumV'])) {
  echo "Sumering värde:";
  sys::flush_page();
  if(port::cacheHoldingSum())
    echo "<span style=\"color: green\"> OK</span>";
  echo '<br>';
}

if(isset($_POST['updateRss'])) {
  echo "Uppdatering RSS:";
  $array = rss::getList();
  if(rss::update($array))
    echo "<span style=\"color: green\"> OK</span>";
  echo '<br>';
}

echo "<br><br> KLART!";
}
include 'pageBottom.php';

?>
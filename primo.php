<?php
set_time_limit(6000);

session_start();
//session_destroy();

$limite_media = 5;
if (isset($_GET['limite_media'])) {
	$limite_media = $_GET['limite_media'];
}

$tini = getmicrotime();

$max = 10000000;
if (isset($_GET['max'])) {
	$max = $_GET['max'];
}

echo "Use: primo.php?max=10000000&limite_media=5";
echo("<pre>");

$primo = array();
$q = true;
$atual = 1;
for ($i = 3; $i <= $max; $i = $i+2) {

	if($q){
		$mult = $i*$i;

		if($mult < $max){
			$quad[$mult] = $i;
		} else {
			$q = false;
		}
	}

	if(isset($quad[$i])){
		$atual = $quad[$i];
		continue;
	}

	$a = false;
	foreach ($primo as $p){

		if($p > $atual){
			break;
		}

		if ($i%$p==0){
			$a = true;
			break;
		}

	}

	if(!$a){
		$primo[] = $i;
	}

}
array_unshift($primo, 2);
$fini = getmicrotime();

print_r("\n");
$tempo = $fini - $tini;
$_SESSION['time'][] = $tempo;
while(sizeof($_SESSION['time']) > $limite_media)
{
	array_shift($_SESSION['time']);
}
echo("tempo: ".getmedia()."\n");

print_r(sizeof($primo)."/$max");
print_r("\n");
print_r($_SESSION['time']);
print_r("\n");
print_r($primo);
print_r("\n");
print_r($quad);


function getmicrotime()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

function getmedia() {
	$soma = 0;
	$i = 0;
	foreach ($_SESSION['time'] as $value) {
		$soma += $value;
		$i++;
	}
	return $soma/$i;
}

?>

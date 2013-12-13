<?php

if (isset($_POST['s'], $_POST['k'])){

$s = $_POST['s'];
$k = $_POST['k'];
$i=0;
$w = "";
if ($s and is_numeric($k)) {
	$l = strlen($s);
	while($i < $l){
		$z1 = ord(substr($s, $i, 1));
		if((97 <= $z1)&&($z1 <= 122)){
			$z1=$z1+$k;
			if($z1 < 97){
				$z1=97-$z1;
				$z1=123-$z1;
			} else if(122 < $z1){
				$z1=$z1-122;
				$z1=96+$z1;
			}
		} else if((65 <= $z1)&&($z1 <= 90)){
			$z1=$z1+$k;
			if($z1 < 65){
				$z1=65-$z1;
				$z1=91-$z1;
			} else if(90 < $z1){
				$z1=$z1-90;
				$z1=64+$z1;
			}
		}
		$z2 = chr($z1); 
		$w .= $z2; 
		$i++; 
	}
	echo " Po zakodowaniu $s z kluczem $k to : $w <br> ";
}
}
?>

<FORM ACTION="" METHOD=POST>
<input type="text" name="s">podaj znaki do kodowania<br>
<input type="text" name="k">klucz<br>
<INPUT TYPE="submit" VALUE="Zamien"><br>

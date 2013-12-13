<?php

function mod($x,$n){
	$r = $x % $n;
	if ($r < 0) $r += abs($n);
	return $r;
}

function odwrotnosc_modulo($n,$p){
	$f = true;
	$a = 1;
    while($f){
		//Ex: 5 × 3 mod 7 = 15 mod 7 = 1 => a = 3
	    $r = ($n * $a) % $p;  
	    if ($r == 1)
			$f = false;
		else
			$a++;
	}	
    return $a;
}

function zakoduj_szyfrem_afinicznym($slowo, $a, $b, $m){
	$w = "";
	//sprawdzenie czy NWD (a,m) == 1
	if(in_array($a,array(1,3,5,7,9,11,15,17,19,21,23,25))){
		$len = strlen($slowo);
		$i=0;
		while($i < $len){
			$x = ord(substr($slowo, $i, 1));
			if((97 <= $x)&&($x <= 122)){
				$x1 = $x - 97;
				$y1 = mod(($a * $x1 + $b), $m);
				$y2 = $y1 + 97;
			} else if((65 <= $x)&&($x <= 90)){
				$x1 = $x - 65;
				//$xch = chr($x);
				//echo "$xch:<br>";
				$y1 = mod(($a * $x1 + $b), $m);
				$y2 = $y1 + 65;
				//echo "x:$x -> y:$y2<br><br>";
			}
			$y = chr($y2); 
			$w .= $y; 
			$i++; 
		}
	} else echo " Klucz a nie spelnia warunku: NWD(a,26) == 1 <br> "; 	
	return $w;
}

function odkoduj_szyfr_afiniczny($zakodowaneslowo, $a, $b, $m){
	$odkodowane = "";
	$len = strlen($zakodowaneslowo);
	$i = 0;
	while($i < $len){
		$y = ord(substr($zakodowaneslowo, $i, 1));
		if((97 <= $y)&&($y <= 122)){
			$y1 = $y - 97;
			$a1 = odwrotnosc_modulo($a,$m);
			$x1 = mod(($a1 * ($y1 - $b)), $m);
			$x2 = $x1 + 97;
		} else if((65 <= $y)&&($y <= 90)){
			$y1 = $y - 65;
			//$ych = chr($y);
			//echo "$ych:<br>";
			$a1 = odwrotnosc_modulo($a,$m);
			$yb = $y1 - $b;
			//echo "$y1 - $b: $yb<br>";
			$a1yb = $a1 * $yb;
			//echo "$a1($y1 - $b): $a1yb<br>";
			$x1 = mod(($a1 * $yb), $m);
			//echo "$a1($y1 - $b) mod $m: $x1<br>";
			$x2 = $x1 + 65;
			//echo "y:$y -> x:$x2<br><br>";
		}
		$x = chr($x2); 
		$odkodowane .= $x; 
		$i++; 
	}
	return $odkodowane;
}

if (isset($_POST['slowo'], $_POST['a'], $_POST['b'])){
	$slowo = $_POST['slowo'];
	$a = $_POST['a'];
	$b = $_POST['b'];
	$zakodowaneslowo = "";
	$odkodowane = "";
	$m = 26;
	if ($slowo and is_numeric($a) and is_numeric($b)) {
		echo " Zakodowanie slowa $slowo z kluczem ($a, $b): f(x)= ax + b mod m <br>";
		$zakodowaneslowo = zakoduj_szyfrem_afinicznym($slowo, $a, $b, $m);
		if ($zakodowaneslowo != "") {
			echo "Zakodowane: $zakodowaneslowo <br>";
			echo "<br> Odkodowanie slowa $zakodowaneslowo z kluczem ($a, $b): d(y)= a^(-1) * (y - b) mod m <br>";
			$odkodowane = odkoduj_szyfr_afiniczny($zakodowaneslowo, $a, $b, $m);		
			echo "Odkodowane: $odkodowane <br><br>";
		}
	} else echo "Podane parametry sa bledne<br>";
}
?>

<FORM ACTION="" METHOD=POST>
<input type="text" name="slowo">Podaj znaki do kodowania (m = 26)<br>
<input type="text" name="a">klucz a (NWD(a,m) == 1)<br>
<input type="text" name="b">klucz b <br>
<INPUT TYPE="submit" VALUE="Zamien"><br>

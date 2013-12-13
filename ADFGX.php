<!-- KODOWANIE-->
<!-- ADFGX -->

<!--
	A	D	F	G	X 
A	b	t	a	l	p
D	d	h	o	z	k
F	q	f	v	s	n
G	g	j	c	u	x
X	m	r	e	w	y

-->

<?php

$arraywiad = array();
$arraywiadsort = array();
$array = array();
$array[0][0] = 'b';
$array[0][1] = 't';
$array[0][2] = 'a';
$array[0][3] = 'l';
$array[0][4] = 'p';
$array[1][0] = 'd';
$array[1][1] = 'h';
$array[1][2] = 'o';
$array[1][3] = 'z';
$array[1][4] = 'k';
$array[2][0] = 'q';
$array[2][1] = 'f';
$array[2][2] = 'v';
$array[2][3] = 's';
$array[2][4] = 'n';
$array[3][0] = 'g';
$array[3][1] = 'j';
$array[3][2] = 'c';
$array[3][3] = 'u';
$array[3][4] = 'x';
$array[4][0] = 'm';
$array[4][1] = 'r';
$array[4][2] = 'e';
$array[4][3] = 'w';
$array[4][4] = 'y';

$wiadomosc="tajna wiadomosc"; // strtolower - string to lower -> do tekstu

echo "wiadomosc: ".$wiadomosc.'<br>';

$haslo="HASLO";

echo "haslo: ".$haslo.'<br><br>';


function printArray($array){
	for($i=0; $i<5; $i++)
		for($j=0; $j<5; $j++){
			echo $array[$i][$j];
			if($j==4) echo "<br/>";		
	  	}
}

function slownik($array){
	$slownik;	
	for($i=0; $i<5; $i++)
	 	for($j=0; $j<5; $j++)
			$slownik[$array[$i][$j]]=wartosc($i, $j);
	 		
return $slownik;
}

function wartosc($i, $j){	
	$zmienna;
	
	if($i==0)     $zmienna='A';
	elseif($i==1) $zmienna='D';
	elseif($i==2) $zmienna='F';
	elseif($i==3) $zmienna='G';
	elseif($i==4) $zmienna='X';
	
	if($j==0)     $zmienna=$zmienna.'A';
	elseif($j==1) $zmienna=$zmienna.'D';
	elseif($j==2) $zmienna=$zmienna.'F';
	elseif($j==3) $zmienna=$zmienna.'G';
	elseif($j==4) $zmienna=$zmienna.'X';
	
return $zmienna;		
}

printArray($array);

$slownik=slownik($array);

$dlugosc_wiadomosci = strlen($wiadomosc);

$zak_wiad_bez_hasla=""; // zakodowana wiadomosc bez hasla
 	
for($i=0; $i<$dlugosc_wiadomosci; $i++){
	$x=$wiadomosc{$i}; // ity znak
	if($x=='i'){
		$x='j'; // brak i
		$zak_wiad_bez_hasla=$zak_wiad_bez_hasla.$slownik[$x];
	}elseif($x!=' ')
		$zak_wiad_bez_hasla=$zak_wiad_bez_hasla.$slownik[$x];
}

echo '<br>'."zakodowana wiadomosc bez hasla: ".'<br><br>'.$zak_wiad_bez_hasla.'<br><br>';

$dlugosc=strlen($zak_wiad_bez_hasla);

echo "dlugosc zakodowanej wiadomosci: ".$dlugosc.'<br>';

$dlugosc_hasla=strlen($haslo);

echo "dlugosc hasla: ".$dlugosc_hasla.'<br>';

$mod=$dlugosc%$dlugosc_hasla;

echo "(modulo: ".$mod.")".'<br>';

$dopisek=$dlugosc_hasla-$mod;

echo "ile x - GX trzeba dodac : ".$dopisek;

$dopiszGX=$slownik['x'];

for($i=0; $i<$dopisek-1; $i++){
 	$zak_wiad_bez_hasla=$zak_wiad_bez_hasla.$dopiszGX;
}

echo '<br>'."zakodowana wiadomosc bez hasla z dopelnieniem: ".'<br><br>'.$zak_wiad_bez_hasla.'<br><br>';

?>
<!--
- haslo nalezy posortowac : H A S L O -> A H L O S Jednoczesnie trzeba pamietac o kolejnosci liter w tym hasle  
  czyli ze struktury takiej:  [{H, 1}, {A, 2}, {S, 3}, {L, 4}, {O, 5}]
  otrzymujemy taka:           [{A, 2}, {H, 1}, {L, 4}, {O, 5}, {S, 3}]

-->
<?php

function haslo_slownik($haslo){
	$dlugosc_hasla=strlen($haslo);
	$haslo_slownik;
	for($i=0; $i<$dlugosc_hasla; $i++)
		$haslo_slownik[$haslo{$i}] = $i;

	// nalezy posortowac slownik wzgledem klucza (liter)
	ksort($haslo_slownik);	 

	//foreach ($haslo_slownik as $key => $val)
	//	echo "$key = $val ";
		
return $haslo_slownik;
}

$haslo_slownik = haslo_slownik($haslo);

?>

<!--
- Wiadomosc $zak_wiad_bez_hasla nalezy wpisac do tablicy dwuwymiarowej:

1 2 3 4 5
H A S L O
---------
A D A F G
D F X A F
X G G D A
F D A D F
X A D F F
G G F G X

-->
<?php

function wiad_to_array($wiad, $haslo){
	$arraywiad = array();
	$lenhasla = strlen($haslo); // ilosc kolumn
	$lenwiad = strlen($wiad);
	$ilosck = $lenwiad / $lenhasla; // ilosc wierszy
	$i = 0;
	for($w=0; $w<$ilosck; $w++){
		$row = array();
		for($k=0; $k<$lenhasla; $k++){
			$x=$wiad{$i};
			$row[] = $x;
			$i++;
		}
		$arraywiad[] = $row;
	}
return $arraywiad;
}

$arraywiad = wiad_to_array($zak_wiad_bez_hasla, $haslo);

?>

<!--
- Nastepnia przepisac do podobnej tablicy dwuwymiarowej poszegolne elemeny po posortowaniu kolumn wzgledem hasla

2 1 4 5 3 - nowa kolejnosc kolumn
A H L O S
---------
D A F G A
F D A F X
G X D A G
D F D F A
A X F F D
G G G X F

-->
<?php

function sortuj_kolumny_wzgledem_hasla($arraywiad, $haslo_slownik, $haslo, $wiad){
	$arraywiadsort = array();
	$lenhasla = strlen($haslo); // ilosc kolumn
	$lenwiad = strlen($wiad);
	$ilosck = $lenwiad / $lenhasla; // ilosc wierszy
	$i = 0;
	
	$hasloParts = str_split($haslo);
	sort($hasloParts);
    //print_r($arraywiad);
	//print_r($haslo_slownik);
	for($w=0; $w<$ilosck; $w++){
		$row = array();
		for($k=0; $k<$lenhasla; $k++){
			$hp = $hasloParts[$k];
		    $hs = $haslo_slownik[$hp];
			//echo "<br/>".$hs."<br/>";
			$x = $arraywiad[$w][$hs];
			//echo "<br/>".$x."<br/>";
			$row[] = $x;
			//print_r($row);
		}
		$arraywiadsort[] = $row;
	}
	
return $arraywiadsort;
}

$arraywiadsort = sortuj_kolumny_wzgledem_hasla($arraywiad, $haslo_slownik, $haslo, $zak_wiad_bez_hasla);

?>

<!--
- wypisac tablice na ekran.
-->

<?php

function wypisz_zakodowana_wiadomosc($arraywiadsort, $haslo, $wiad){
	
	$lenhasla = strlen($haslo); // ilosc kolumn
	$lenwiad = strlen($wiad);
	$ilosck = $lenwiad / $lenhasla; // ilosc wierszy
	
	for($w=0; $w<$ilosck; $w++){		
		for($k=0; $k<$lenhasla; $k++){
			echo $arraywiadsort[$w][$k];
		}
	}
}

wypisz_zakodowana_wiadomosc($arraywiadsort,$haslo, $zak_wiad_bez_hasla);

?>

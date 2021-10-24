<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kwota = $_REQUEST ['kwota'];
$procent = $_REQUEST ['procent'];
$okres = $_REQUEST ['okres'];


// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($kwota) && isset($okres) && isset($procent))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $kwota == "") {
	$messages [] = 'Nie podano kwoty kredytu';
}
if ( $procent == "") {
	$messages [] = 'Nie podano oprocentowania';
}

if ( $okres == "") {
    $messages [] = 'Nie podano okresu kredytowania';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $kwota )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}

    if (! is_numeric( $okres )) {
        $messages [] = 'Trzecia wartość nie jest liczbą całkowitą';
    }

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$kwota = intval($kwota);
    $okres = intval($okres);
    $raty_w_roku =12;
    $liczba_rat = 12*$okres;

	//wykonanie operacji
      $b = $kwota *($procent/100);
      $l = $b*$okres;
      $g = $kwota + $l;
    $result = $g/$liczba_rat;
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
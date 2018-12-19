$polaczenie = @mysqli_connect('localhost', 'root', '', 'pai_butnicki');
  if (!$polaczenie) {
    die('Wystąpił błąd połączenia: ' . mysqli_connect_errno());
  }
  @mysqli_query($polaczenie, 'SET NAMES utf8');

  $sql = 'SELECT `id`, `nazwa`
               FROM `kategorie`
               ORDER BY `nazwa`';
  $wynik = mysqli_query($polaczenie, $sql);
  if (mysqli_num_rows($wynik) > 0) {
  	echo "<ul>" . PHP_EOL;
    while (($kategoria = @mysqli_fetch_array($wynik))) {
      echo '<li><a href="' . $_SERVER["PHP_SELF"] . '?kat_id=' . $kategoria['id'] . '">' . $kategoria['nazwa'] . '</a></li>' . PHP_EOL;
    }
    echo "</ul>" . PHP_EOL;
  } else {
    echo 'wyników 0';
  }

  //Pobieramy dane produktów z bazy dla wybranej (metodą GET) kategorii
  $kat_id = isset($_GET['kat_id']) ? (int)$_GET['kat_id'] : 1;
  $sql = 'SELECT `nazwa`, `opis`
               FROM `produkty`
               WHERE `kategoria_id` = ' . $kat_id .
               ' ORDER BY `nazwa`';
  $wynik = mysqli_query($polaczenie, $sql);
  if (mysqli_num_rows($wynik) > 0) {
    while (($produkt = @mysqli_fetch_array($wynik))) {
        echo '<p><b>' . $produkt['nazwa'] . '</b>: ' . $produkt['opis'] . '</p>' . PHP_EOL;
    }
  } else {
    echo 'wyników 0';
  }
mysqli_close($polaczenie);
<?php
session_start();
?> 

<html>
    <head>
    <meta http-equiv="Content-type" content="text/html"  charset="utf-8" " /><link rel="stylesheet" href="arkusz.css">
    <title>KWIACIARZ</title>
    </head>
    <body><center>
        <header> 🌺 Sklep KWIACIARZ 🌺
        <nav>
        <a href='produkty.php?limit=0'>| PRODUKTY |</a>
        <a href='uzytkownicy.php'>| UZYTKOWNICY |</a>
        <a href='zamowienia.php'><b>| ZAMÓWIENIA |</b></a>
        <a href='wylogowanie.php'>| WYLOGUJ SIĘ |</a>
        </nav></header>
        <section>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sklep";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            
            $data1 = $_POST["data1"];
            $data2 = $_POST["data2"];
            $rodzaj = $_POST["rodzaj"];
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if ($rodzaj==1){
                echo "<h2 style=font-size:28px;>Wygenerowany raport dla daty od ",$data1," do ", $data2,"</h2><br>";
                echo "<h2>10 najczęściej kupowanych roślin:</h2>";
                echo"<table style=width:90%;>
                <tr><th>Nazwa produktu</th><th>Ilość sprzedanych</th><th>Cena jednostkowa</th><th>Suma</th></tr>";

                $sql = "SELECT zp.cenaZP, z.data_zamowienia, z.id_zamowienia, p.nazwa, sum(zp.ilosc) as 'ilość' 
                FROM zamowienie as z join zamowione_produkty as zp on z.id_zamowienia=zp.id_zamowienia 
                join produkty as p on zp.id_produktu=p.id_produktu 
                join kategorie as k on k.id_kategorii=p.id_kategorii 
                WHERE (k.nazwa regexp 'rosliny' AND (data_zamowienia BETWEEN CAST('$data1' AS DATE) AND CAST('$data2' AS DATE))) 
                group by zp.id_produktu order by sum(zp.ilosc) desc limit 10";
    
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_assoc($result) ){ 
                        $suma=$row['ilość']*$row['cenaZP'];
                        $sumaC+=$suma;
                        echo "<tr><td align=center>",$row['nazwa'],"</td><td align=center>",$row['ilość'],
                        "</td><td align=center>",$row['cenaZP'],"</td><td align=center>".$suma." zł</td></tr>";
                    }
                }
                else {
                    echo "brak produktów do wygenerowania raportu :(";
                }   
            }
            elseif ($rodzaj==2){
                echo "<h2 style=font-size:28px;>Wygenerowany raport dla daty od ",$data1," do ", $data2,"</h2><br>";
                echo "<h2>5 najczęściej kupiowanych produktów zaczynających się na literę Q:</h2>";
                echo"<table style=width:90%;>
                <tr><th>Nazwa produktu</th><th>Ilość sprzedanych</th><th>Cena jednostkowa</th><th>Suma</th></tr>";
                
                $sql = "SELECT zp.cenaZP, z.data_zamowienia, z.id_zamowienia, p.nazwa, sum(zp.ilosc) as 'ilość' 
                FROM zamowienie as z join zamowione_produkty as zp on z.id_zamowienia=zp.id_zamowienia 
                join produkty as p on zp.id_produktu=p.id_produktu 
                WHERE (p.nazwa like 'q%' AND (data_zamowienia BETWEEN CAST('$data1' AS DATE) AND CAST('$data2' AS DATE))) 
                group by zp.id_produktu
                order by sum(zp.ilosc) desc limit 5";
    
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_assoc($result) ){ 
                        $suma=$row['ilość']*$row['cenaZP'];
                        $sumaC+=$suma;
                        echo "<tr><td align=center>",$row['nazwa'],"</td><td align=center>",$row['ilość'],
                        "</td><td align=center>",$row['cenaZP'],"</td><td align=center>".$suma." zł</td></tr>";
                    }
                }
                else {
                    echo "brak produktów do wygenerowania raportu :(";
                }   
            }            
            elseif ($rodzaj==3){
                echo "<h2 style=font-size:28px;>Wygenerowany raport dla daty od ",$data1," do ", $data2,"</h2><br>";
                echo "<h2>10 najczęściej kupiowanych produktów kończących się literą A:</h2>";
                echo"<table style=width:90%;>
                <tr><th>Nazwa produktu</th><th>Nazwa kategorii</th><th>Ilość sprzedanych</th>
                <th>Cena jednostkowa</th><th>Suma</th></tr>";

                $sql = "SELECT zp.cenaZP, z.data_zamowienia, z.id_zamowienia, p.nazwa, k.nazwa as 'nazwaK',
                sum(zp.ilosc) as 'ilość' 
                FROM zamowienie as z join zamowione_produkty as zp on z.id_zamowienia=zp.id_zamowienia 
                join produkty as p on zp.id_produktu=p.id_produktu 
                join kategorie as k on k.id_kategorii=p.id_kategorii 
                WHERE (p.nazwa regexp 'a$' and (data_zamowienia BETWEEN CAST('$data1' AS DATE) AND CAST('$data2' AS DATE))) 
                group by zp.id_produktu order by sum(zp.ilosc) desc limit 10";
    
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_assoc($result) ){ 
                        $suma=$row['ilość']*$row['cenaZP'];
                        $sumaC+=$suma;
                        echo "<tr><td align=center>",$row['nazwa'],"</td><td align=center>",$row['nazwaK'],"</td>
                        <td align=center>",$row['ilość'],
                        "</td><td align=center>",$row['cenaZP'],"</td><td align=center>".$suma." zł</td></tr>";
                    }
                }
                else {
                    echo "brak produktów do wygenerowania raportu :(";
                }   
            }
            elseif ($rodzaj==4){
                echo "<h2 style=font-size:28px;>Wygenerowany raport dla daty od ",$data1," do ", $data2,"</h2><br>";
                echo "<h2>5 najdrozszych sprzedanych produktów:</h2>";
                echo"<table style=width:90%;>
                <tr><th>Nazwa produktu</th><th>Nazwa kategorii</th><th>Ilość sprzedanych</th>
                <th>Cena jednostkowa</th><th>Suma</th></tr>";

                $sql = "SELECT zp.cenaZP, z.data_zamowienia, z.id_zamowienia, p.nazwa, k.nazwa as 'nazwaK',
                sum(zp.ilosc) as 'ilość' 
                FROM zamowienie as z join zamowione_produkty as zp on z.id_zamowienia=zp.id_zamowienia 
                join produkty as p on zp.id_produktu=p.id_produktu 
                join kategorie as k on k.id_kategorii=p.id_kategorii 
                WHERE ((z.data_zamowienia BETWEEN CAST('$data1' AS DATE) AND CAST('$data2' AS DATE))) 
                group by zp.id_produktu order by zp.cenaZP desc limit 5";
    
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_assoc($result) ){ 
                        $suma=$row['ilość']*$row['cenaZP'];
                        $sumaC+=$suma;
                        echo "<tr><td align=center>",$row['id_produktu'],$row['nazwa'],"</td><td align=center>",$row['nazwaK'],"</td>
                        <td align=center>",$row['ilość'],
                        "</td><td align=center>",$row['cenaZP'],"</td><td align=center>".$suma." zł</td></tr>";
                    }
                }
                else {
                    echo "brak produktów do wygenerowania raportu :(";
                }   
            }
            elseif ($rodzaj==5){
                //echo "<h2 style=font-size:28px;>Wygenerowany raport dla daty od ",$data1," do ", $data2,"</h2><br>";
                echo "<h2>20 produktów, których jest najwięcej na stanie (aktualnie):</h2>";
                echo"<table style=width:90%;>
                <tr><th>Nazwa produktu</th><th>Nazwa kategorii</th><th>Ilość na stanie</th>
                <th>Cena</th></tr>";

                $sql = "SELECT p.nazwa, p.cena, k.nazwa as 'nazwaK', p.dostepnosc as 'ilość' 
                FROM produkty as p join kategorie as k on k.id_kategorii=p.id_kategorii 
                order by ilość desc limit 20";
    
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_assoc($result) ){ 
                        $suma=$row['ilość']*$row['cenaZP'];
                        $sumaC+=$suma;
                        echo "<tr><td align=center>",$row['nazwa'],"</td><td align=center>",$row['nazwaK'],"</td>
                        <td align=center>",$row['ilość'],
                        "</td><td align=center>",$row['cena']," zł</td></tr>";
                    }
                }
                else {
                    echo "brak produktów do wygenerowania raportu :(";
                }   
            }
            elseif ($rodzaj==6){
                //echo "<h2 style=font-size:28px;>Wygenerowany raport dla daty od ",$data1," do ", $data2,"</h2><br>";
                echo "<h2>20 produktów, których jest najwięcej na stanie (aktualnie):</h2>";
                echo"<table style=width:90%;>
                <tr><th>Nazwa produktu</th><th>Nazwa kategorii</th><th>Ilość na stanie</th>
                <th>Cena</th></tr>";

                $sql = "SELECT p.nazwa, p.cena, k.nazwa as 'nazwaK', p.dostepnosc as 'ilość' 
                FROM produkty as p join kategorie as k on k.id_kategorii=p.id_kategorii 
                order by ilość asc limit 20";
    
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_assoc($result) ){ 
                        $suma=$row['ilość']*$row['cenaZP'];
                        $sumaC+=$suma;
                        echo "<tr><td align=center>",$row['nazwa'],"</td><td align=center>",$row['nazwaK'],"</td>
                        <td align=center>",$row['ilość'],
                        "</td><td align=center>",$row['cena']," zł</td></tr>";
                    }
                }
                else {
                    echo "brak produktów do wygenerowania raportu :(";
                }   
            }
        mysqli_close($conn);
        echo '</table></div></div></div><br>
        <a class=link>Suma całkowita: ',$sumaC," zł</a><br><br>";
        ?>
        <b><a class=link href=raporty.php>Powrót do generowania raportów</a></b>
        <footer>
            <p>Autorem tej strony TYLKO i WYŁĄCZNIE jest: PAULINA ORMANOWSKA</p><br>
        </footer></section></center></body>
    </html>

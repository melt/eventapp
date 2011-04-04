<?php namespace nmvc; ?>
<?php $this->layout->enterSection("head"); ?>
    <title>Welcome to nanoMVC!</title>
    <style>
        body {
            font-size: 16px;
            font-family: sans-serif;
        }
        #wrap {
            width: 800px;
            margin: 0 auto;
        }
        li {
            margin-bottom: 16px;
        }
    </style>
<?php $this->layout->exitSection(); ?>
<div id="wrap">
    <h1>TDDD27 - Advanced Web Programming</h1>
    <p>Gruppen består av Per Jonsson (perjo984@student.liu.se). Projektadressen är http://eventapp.omnicloud.org.</p>

    <h2>Projektbeskrivning</h2>
    <ul>
        <li>
        Webbapplikation för att hantera en enkel medlemsdatabas samt inbjudningar till evenemang.
        </l>
        <li>
        Applikationen ska nyttjas av ett nätverk där olika städer runt om i världen fungerar som hubbar där evenemang arrangeras.
        </li>
        <li>
        Fyra typer av användare ska finnas i applikationen: gäster, medlemmar, arrangörer och administratörer. Varje användare har en särskild behörighetsnivå som låter denne utföra vissa bestämda aktiviteter i applikationen.

        </li>
        <li>
När arrangörer gör en inbjudan till ett evenemang väljer de bland medlemmar i en lista.

 skickas ett e-postmeddelande till de användare som arrangören väljer att bjuda in. Dessa användare har sedan möjlighet att besvara inbjudan genom att bekräfta eller avslå närvaro.

        </li>
        <li>
        Inloggning i systemet sker via Facebook-Connect med vanlig login som fallback.
        </li>

        <li>
Ett publikt API kommer att skrivas så att data kan extraheras och presenteras på en extern Wordpress-baserad webbplats. Den data som ska presenteras består av evenemang i en viss hubb.

        </li>
         <h2>Teknologier</h2>



        <li>
   Applikationen ska implementeras huvudsakligen i språket PHP.
        </li>
        <li>
       För servern kommer ramverket NanoMVC att nyttjas.
        </li>
        <li>
       För klienten kommer ramverket JQuery att nyttjas.
        </li>
        <li>
       Databas kommer att vara MySQL.
        </li>
        <li>
       Facebook API (Facebook Connect) kommer att användas för inloggningsfunktionen.
        </li>
        <li>
       Subversion kommer att användas för versionshantering av projektet.
        </li>

         <h2>Fokus på betyg</h2>
         <li>5</li>
</div>
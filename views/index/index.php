<?php namespace nmvc; ?>
<?php $this->layout->enterSection("head"); ?>
    <title>TDDD27 Advanced Web Programming</title>
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
När arrangören gör en inbjudan till ett evenemang väljer denne bland medlemmar i en lista. Arrangören har dessutom möjlighet att bjuda in gäster genom att fylla i deras e-postadresser.
Vid inbjudan skickas ett e-postmeddelande till de användare (medlemmar och gäster) som arrangören väljer att bjuda in. E-postmeddelandet innehåller en unik länk som användaren nyttjar för att bekräfta eller avslå sin närvaro. I fallet då användaren bekräftar sin närvaro efterfrågas kompletterande uppgifter via ett webbaserat formulär.

        </li>
        <li>
        Inloggning i systemet sker via Facebook Connect med vanlig login som fallback.
        </li>

        <li>
        Via Facebooks API hämtas uppgifter om användaren såsom namn, aktuell stad och telefonnummer.
        </li>

        <li>
Applikationen har ett publikt API som gör det möjligt att extrahera och presentera data på en extern Wordpress-baserad webbplats. Den data som ska presenteras består av evenemang i en viss hubb.

        </li>


                <li>
Google Maps kommer att integreras för varje evenemang där adress angivits för att visa vart evenemanget äger rum.
        </li>
         <h2>Teknologier</h2>



        <li>
   Applikationen ska implementeras huvudsakligen i språket PHP.
        </li>
        <li>
       För servern kommer ramverket <a href="http://svn.omnicloud.org/library/nanomvc/trunk/">NanoMVC</a> att nyttjas. Ramverket bygger på Module-View-Controller och fullständigt objektorienterad programmering. Det har ett ORM-lager mot databasen vilket innebär att alla databastabeller definieras och omfaktoreras genom modeller och modellvariabler i källkoden. NanoMVC har även ett kompakt abstraktionslager mot databasen för dataåtkomst som hämtar data till vanliga PHP-instanser vilket gör det enkelt att presentera data i vyerna.
               </li>
        <li>
       För klienten kommer ramverket JQuery att nyttjas. Med JQuery kommer processen att bjuda in deltagare bli dynamisk i det avseende att arrangören kan bläddra i listan över medlemmar och lägga till medlemmar i sitt inbjudningsformulär samtidigt.
        </li>
       <li>
       För att skicka mail i både Plaintext och HTML kommer NanoMVCs mailfunktion att användas som utökar den inbyggda mailfunktionen i PHP. Dessutom kommer spoolingfunktionen användas som lagrar mailen tillfälligt i databasen i det fall att mailservern är ur funktion, för att säkerställa att alla inbjudningar skickas ut från servern.
       </li>
        <li>
       Databas kommer att vara MySQL. Åtkomst kommer att hanteras via NanoMVC vilket beskrivs ovan.
        </li>
        <li>
       Facebook API (Facebook Connect) kommer att användas för inloggningsfunktionen.
        </li>
       <li>
       Google Maps kommer att användas för kartvisningen.
        </li>
        <li>
       Subversion kommer att användas för versionshantering av projektet.
        </li>


         <h2>Rättigheter till kod</h2>
         <li>Koden kommer att distribueras fritt för att användas som exempelapplikation till ramverket NanoMVC</li>

         <h2>Fokus på betyg</h2>
         <li>5</li>
</div>
### Overzicht alle routes

+ ALLE routes (behalve /advies/get/{id}) werken alleen als er een token wordt meegestuurd in de header van het request. De token valt te genereren door /authenticate aan te roepen (zie uitleg bij logopedisten routes) 

GET: /checkIfAuthenticated
Route die checkt of een logopedist al ingelogt is, zo ja return true anders wordt er false gereturned.

### Logopedisten routes

POST:: /authenticate
Als de gebruiker nog geen token heeft wordt deze route aangeroepen. Er moet een post request gestuurd worden naar de route /authenticate met email en password. Als email en password in de database voorkomen dat wordt er een token aangemaakt en getourneerd.

GET: /logopedist/index
Retourneert alle logopedisten uit de database

GET: /logopedist/get/{id}
Retourneert een logopedist op basis van het meegegeven ID

GET: /logopedist/getlocatie/{locatie}
Retourneert een array met: De logopedisten van de meegegeven locatie en per logopedist de gekoppelde patienten.

POST: /logopedist/add
Maakt een logopedist aan en voegt deze toe aan de database. De logopedist wordt aangemaakt op basis van de meegegeven velden uit het post request.


### Patienten routes

GET: /patient/index
Retourneert alle patienten uit de database

GET: /patient/get/patient_nummer}
Retourneert een patient op basis van het meegegeven patient_nummer

GET: /patient/getlocatie/{locatie}
Retourneert een array met alle patienten van de meegegeven locatie, de gekoppelde logopedist en het gekoppelde advies mocht die bestaan.

POST: /patient/add
Voegt een patient toe op basis van de meegegeven waardes in het post field.

Velden die meegegeven moeten worden: 
- logopedist_id
- geboortedatum
- patient_nummer
- locaties
- wachtwoord

POST: /patient/login
Route checkt of de meegegeven credetials uit het post request correct zijn en voorkomen in de database. Als ze correct zijn en voorkomen dan wordt er true geretourneerd, mocht dit niet het geval zijn dan word de error gerouterneerd. 

Als er een advies gekoppeld is aan de patient, dan wordt het advies ook gereturned in het request. 

Credentials die voor moeten komen in het request:
- Email (string)
- password (string)


### Advies routes

GET: /advies/get/{id}
Retourneert een advies op basis van het meegegeven id

POST: /advies/add
Voegt een advies toe aan de database op basis van de meegeegven waardes uit het post request.

Velden die meegegeven moeten worden in het post request:
- patient_id (int)
- advies (array)
- beknopt_advies (array)
- zichtbaar (boolean)

GET: /advies/delete/{id}
Verwijdert een advies uit de database op basis van het meegegeven ID.

POST: /advies/update
In het post request wordt het patient id meegegeven van het advies. Op basis van dit patient id wordt er een advies uit de database opgehaald. De waardes van dit advies worden geupdate met de nieuwe waardes uit het post request.

Velden uit het postrequest:
- patient_id
- advies
- beknopt advies
- zichtbaar
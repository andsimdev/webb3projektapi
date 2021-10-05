# Webbutveckling 3, projekt
## API-webbtjänst

> Webbtjänsten ansluter mot en databas med tre olika tabeller för att lagra information om tidigare studier, arbeten och skapade webbplatser.
> Webbtjänsten stödjer http-metoderna GET, POST, PUT och DELETE för att hämta, lagra, ändra och radera data ur databasen.
> Webbtjänsten tar emot och skickar svar i JSON-format.

<br>

### GET
- För att hämta alla poster ur en tabell görs http-anrop utan någon medskickad parameter.
- För att hämta en enskild post ur en tabell skickas skickas parametern id med i anropet.
---
### POST
- För att skapa en ny post i en tabell skickas ett POST-anrop med data i JSON-format i anropet. Datan består av 4 kategorier för respektive tabell. Minsta teckenlängd är 4 tecken per post.
*Följande delar behöver skickas med för de respektive tabellerna:*

**STUDIER**
| Definition | Betydelse |
| ----------- | ----------- |
| studtitle | Rubrik för studier |
| university | Universitet/lärosäte |
| studstartdate | Startdatum för studier (år/månad) |
| studenddate | Slutdatum för studier (år/månad) |
<br>

**ARBETEN**
| Definition | Betydelse |
| ----------- | ----------- |
| emptitle | Rubrik för arbetet |
| empplace | Plats/arbetsgivare för arbetet |
| empstartdate | Startdatum för arbetet (år/månad) |
| empenddate | Slutdatum för arbetet (år/månad) |
<br>

**WEBBSIDOR**
| Definition | Betydelse |
| ----------- | ----------- |
| sitetitle | Rubrik för webbplatsen |
| siteurl | URL till webbplatsen |
| sitedesc | Beskrivning av webbplatsen |
| siteimage | Sökväg till bild för webbplatsen |
<br>

*Exempel på medskickad JSON-data i POST-anrop för att lagra ny post i tabellen för studier:*

```
{
  "studtitle": "Webbutveckling, 120 hp",
  "university": "Mittuniversitetet",
  "studstartdate": "Augusti 2020",
  "studenddate": "Juni 2022"
}
```


---
### PUT
- För att ändra en befintlig post i databasen skickas ett PUT-anrop med komplett datastruktur i JSON-format som innehåller all ny data som ska lagras. PUT-anropet skickas med parametern id som ska motsvara id:t för den enskilda posten som ska uppdateras.
- De olika kategorierna av data är desamma som i POST-anrop (se ovan).
---
### DELETE
- För att radera en post skickas ett DELETE-anrop med parametern id som motsvarar id:t för den posten som ska raderas.

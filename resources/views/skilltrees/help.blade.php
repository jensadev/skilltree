@extends('layouts.app')

@section('content')
    <div class="container">
        <section style="padding-top: 7rem;"  id="start">
            <h1>Kom igång</h1>
            <p class="lead">Varning för svengelska, översättning kommer förhoppningsvis. Funkar det inte, tryck F5, rensa cache i din webbläsare eller hojta.</p>
            <p>Skapa ett Skilltree genom att clicka på <i class="material-icons">create_new_folder</i>, fyll i en titel och en kort beskrivning av trädet. Om du vill så kan du redan nu lägga till färdigheterna. Klicka på create och du kommer att tas till ditt träd.</p>
            <p>Du är nu på applikationens huvudsida där du kan kontroller alla aspekter av ditt träd, trädets namn visas till vänster och brevid uppe till höger kommer du åt ett antal iconer för att jobba med trädet.</p>
            <p>Du kan i ordningen:</p>
            <ol style="list-style: none;">
                <li class="list-item"><i class="material-icons">add_box</i> lägga till en ny skill</li>
                <li class="list-item"><i class="material-icons">person_add</i> bjuda in andra lärare</li>
                <li class="list-item"><i class="material-icons">clear_all</i> rensa alla kopplingar och positioner</li>
                <li class="list-item"><i class="material-icons">restore</i> ladda om positioner</li>
                <li class="list-item"><i class="material-icons">save</i> spara positionerna</li>
                <li class="list-item"><i class="material-icons">settings</i> hantera trädet</li>
            </ol>
            <h2>Testa</h2>
            <p>Börja med att lägga till en ny skill, den kommer då att placeras i ditt Skilltree tillsammans med trädets rot som är själva trädets information.</p>
            <p>Första gången ett träd laddas är färdigheternas positioner slumpade, så om du saknar en färdighet eller sidan visar en laddicon,             <div
                class="spinner-border"
                role="status"
                style="width:16px; height:16px;"
            >
                <span class="sr-only">Loading...</span>
            </div> testa då att dra i en färdighet och spara/ladda sedan om sidan(F5). Ser du ingen färdighet så kan du hålla nere ALT knappen och då dra/zooma med musen/scrollhjulet. Behöver du återställa detta tryck på F5.</p>
            <p>Alla skills kan dras runt och positioneras på sidan. Du kan koppla ihop skills genom att hovra muspekaren på en skill, klicka på en av pilarna och sedan på den färdighet du vill koppla ihop med.</p>
            <p>Är du inte nöjd med dina kopplingar eller positioner så kan du rensa alla, enstaka kopplingar (genom att klicka på <i class="material-icons">edit</i> på den enskilda färdigheten) eller ladda dem från databasen.
                Positionerna sparas lokalt i din webbläsare tills du trycker på <i class="material-icons">save</i> ikonen.</p>
            <h2>Manage Skilltree</h2>
            <p>Öppna nu inställningarna för trädet genom att klicka på <i class="material-icons">settings</i>. Här har du möjligheten att uppdatera trädets titel, beskrivning samt lägga till anteckningar. 
            För tillfället är kopplingen till Google Classroom inte på, men det kommer.</p>
            <p>Under Students fliken så hanterar du de elever du kopplar till trädet. Börja med att bjuda in en eller flera elever genom att trycka på <i class="material-icons">group_add</i>, det öppnar sig då en ruta där du kan klistra 
            in en kommaseparerad lista över elevernas email (Som den som du kan kopiera från en klass i classroom), tryck sedan på Add students.</p>
            <p>Ladda sedan om sidan och gå tillbaka till Students tabben. Du kommer nu se en lista över alla inbjudna elever. Eleverna har inte ett konto före de loggar in på sidan, då kopplas deras Gmail konto och address till deras status.
            Du kan nu klicka på elevernas namn i listan för att få en lista över deras framsteg inom trädet (sorterade efter tillhörigheten till en skill). Varje Task listas här som är kopplad till trädet och du kan uppdateras dess status. 
            Om du lägger till nya Skills/Tasks på trädet så är det viktigt att du trycker på <i class="material-icons">refresh</i> ikonen bredivd elevens namn/email för att uppdatera hens framsteg.</p>
            <p>Behöver du koppla bort en elev från trädet klickar du på <i class="material-icons">delete</i>.</p>
            <h2>Edit Skill</h2>
            <p>Varje färdighet kan redigeras genom att klicka på <i class="material-icons">edit</i>. Gränssnittet låter dig här ändra titel och beskrivning samt lägga till en bakgrunds-ikon. Ikonen behöver du välja från
            <a href="https://material.io/resources/icons/?icon=create_new_folder&style=sharp">Material Icons</a>, för att välja en ikon skriv in dess namn i fältet.</p>
            <p>Förutom detta så kan du lägga till Tasks / Uppgifter till färdigheten. För att göra detta så skriver du in uppgiftens namn i fältet samt en länk om du så önskar (måste skrivas med http://en.fungerande.url, knasar det tryck F5).
            För att spara Uppgiften trycker du på <i class="material-icons">save</i> ikonen brevid fältet (Update skill sparar inte). Du får då möjlighet att redigera <i class="material-icons">edit</i> / ta bort <i class="material-icons">delete</i> Uppgiften.</p>

            <h2>Elevens gränssnitt</h2>
            <p>Sidans och trädets utformning skiljer sig något från lärarens.Eleven kan inte flytta på färdigheterna eller skapa kopplingarna, utan de laddas från databasen (som du sparat <i class="material-icons">save</i>). 
            För att uppdatera trädets positioner behöver eleven logga ut och ladda om / skapa en ny flik.</p>
            <p>Färdiheterna uppdateras när du som lärare har kryssat i att en elev klarat en Task och eleven behöver ladda om sidan för att se detta.</p>
        </section>
        <section id="video">
            <h1>Demo</h1>
            <p class="lead">En kort demo över sidans funktioner</p>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe
                    class="mx-auto d-block embed-responsive-item pb-5"
                    width="560" 
                    height="315" 
                    src="https://www.youtube.com/embed/u_I3aVLqHNo"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
            </div>
        </section>
        <section id="report">
            <h1 >Rapportera ett problem</h1>
            <p>Ett formulär som du kan se... <a href="mailto:jens.andreasson@ga.ntig.se">jens.andreasson@ga.ntig.se</a></p>
        </section>
    </div>

@endsection
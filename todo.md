# Checklist

- [X] Entro primi 500 caratteri specifica linguaggio ("it") e alfabeto (UTF-8)
- [X] Codice html valido
- [X] Link con un proprio stile non ripreso da altre parti non clickabili
- [X] Norme interne sempre rispettate (Se ho uno stile per un elemento non clickabile non posso riusarlo per un altro link)
- [X] Navigabilità da mobile
- [ ] Stampa
- [X] Link per non vedenti per saltare menù, news e il "torna su" (aiuti alla navigazione)
- [X] Utilizzo aria-label per screen reader
- [X] Span per parole estere
- [X] Tag abbr per abbreviazioni
- [X] Evitare stacked menu
- [X] Dimensione minima mobile tasti clickabili 30w x 44hpx 44w x 30h px
- [X] Alt delle immagini dello slideshow
- [ ] Controllare hover per i cellulari
- [X] Fixare span Home
- [X] Fixare cambio tema permanente quando clicco in altre pagine
- [X] Fare il test delle immagini con i plugin di chrome
- [X] Aggiungere "Salta alla navigazione"
- [X] Fixare tutti i tabIndex
- [X] footer per mobile
- [X] (MB) Chiedere alla prof emoji
- [X] Description per register e login
- [ ] Recensioni e/o login come admin per proditti
- [X] Area described by al posto di summary(XHTML) nella tabella
- [X] Class e Id per elementi uguali, ma in pagine diverse
- [X] aggiungere <ahref="#firstAvaiableContent"class="hidden">Salta al primo contenuto `</a>` e id firstAvaiableContent per ogni pagina
- [X] Sistemare tutti i contrasti
- [X] Riportare tutti i valori dei colori allo script change theme, settare correttamente i nuovi colori per il tema chiaro
- [X] chech [https://wave.webaim.org/]()
- [X] controllare "ti trovi in" duplicato
- [ ] Decidere numero massimo di caratteri da mettere nella descrizione prodotto e in base a quello limitarli da php + check JS per evitare di sbordare dalle card.

Check di accessibilità con TotalValidator:

- [X] chiSiamo manca di description (content)
- [X] Inserire gli alt nelle immagini dello slideshow (gli alt devono essere al massimo 75 caratteri, se la descrizione è più lunga si usi longdesc con classe helps che lo nasconde)(credo che long desc sia deprecato e sostituito da un aria describedby con id che punta ad un p nascosto contentente la descrizione)
- [X] quando finito cambiare link in 404.html perchè vanno a gdr00.it
- [ ] mettere tabindex-1 sulle frecec delle card perchè accessibili tramite tab senza l'uso delle frecce che appesantiscono solo il contenuto per gli screen reader
- [ ] pagina error500

----------------------------- Luca & Matteo --------------------------------------------

- [X] regex su titolo e altro testo
- [X] caso in cui il testo è in lingua straniera (controllare pulisci input che non rimuova cose che ci interessano)
- [X] elimina
- [X] controllare lato server estensione immagina corretta
- [X] bug nel caso di prodotti in lingua straniera: nell'html inserisce degli " " che non dovrebbero esserci
- [X] stile prodotti: o 3 card per riga o più spazio per le card
- [X] fixare bordo su form di contatto con il tema chiaro
- [X] rimettere nel form i tipi dell'immagine consentiti

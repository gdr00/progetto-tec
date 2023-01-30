# Checklist

- [X] Entro primi 500 caratteri specifica linguaggio ("it") e alfabeto (UTF-8)
- [ ] Codice html valido
- [ ] Link con un proprio stile non ripreso da altre parti non clickabili
- [ ] Norme interne sempre rispettate (Se ho uno stile per un elemento non clickabile non posso riusarlo per un altro link)
- [ ] Navigabilità da mobile
- [ ] Stampa
- [ ] Link per non vedenti per saltare menù, news e il "torna su" (aiuti alla navigazione)
- [ ] Utilizzo aria-label per screen reader
- [ ] Span per parole estere
- [ ] Tag abbr per abbreviazioni
- [ ] Evitare stacked menu
- [ ] Dimensione minima mobile tasti clickabili 30w x 44hpx 44w x 30h px
- [ ] Alt delle immagini dello slideshow
- [ ] Controllare hover per i cellulari
- [ ] Fixare span Home
- [X] Fixare cambio tema permanente quando clicco in altre pagine
- [ ] Fare il test delle immagini con i plugin di chrome
- [X] Aggiungere "Salta alla navigazione"
- [X] Fixare tutti i tabIndex
- [ ] footer per mobile
- [ ] (MB) Chiedere alla prof emoji
- [ ] Description per register e login
- [ ] Recensioni e/o login come admin per proditti
- [X] Area described by al posto di summary(XHTML) nella tabella
- [ ] Class e Id per elementi uguali, ma in pagine diverse
- [ ] aggiungere <ahref="#firstAvaiableContent"class="hidden">Salta al primo contenuto `</a>` e id firstAvaiableContent per ogni pagina
- [ ] Sistemare tutti i contrasti
- [X] Riportare tutti i valori dei colori allo script change theme, settare correttamente i nuovi colori per il tema chiaro
- [ ] chech [https://wave.webaim.org/]()
- [ ] controllare "ti trovi in" duplicato
- [ ] Decidere numero massimo di caratteri da mettere nella descrizione prodotto e in base a quello limitarli da php + check JS per evitare di sbordare dalle card.

Check di accessibilità con TotalValidator:

- [ ] chiSiamo manca di description (content)
- [ ] Inserire gli alt nelle immagini dello slideshow (gli alt devono essere al massimo 75 caratteri, se la descrizione è più lunga si usi longdesc con classe helps che lo nasconde)(credo che long desc sia deprecato e sostituito da un aria describedby con id che punta ad un p nascosto contentente la descrizione)
- [ ] quando finito cambiare link in 404.html perchè vanno a gdr00.it
- [ ] mettere tabindex-1 sulle frecec delle card perchè accessibili tramite tab senza l'uso delle frecce che appesantiscono solo il contenuto per gli screen reader
- [ ] pagina error500


----------------------------- Luca & Matteo --------------------------------------------
- [ ] regex su titolo
- [ ] caso in cui il testo è in lingua straniera (controllare pulisci input che non rimuova cose che ci interessano)
- [ ] modifica 
- [ ] elimina
# 🚚 Laravel Artisan Ledger

> **La soluzione definitiva per la gestione dei corrispettivi giornalieri in Laravel.**

**Artisan Ledger** nasce dall'esigenza di semplificare la contabilità quotidiana per artigiani, trasportatori e piccole imprese. Spesso i gestionali standard sono troppo complessi; questo pacchetto offre un'interfaccia pulita, reattiva e focalizzata solo su ciò che conta: **quanto hai incassato e come.**

---

## ✨ Perché scegliere Artisan Ledger?

Monitorare gli incassi non dovrebbe essere un lavoro a tempo pieno. Con questo pacchetto integrato nella tua applicazione Laravel, ottieni:

* **⚡ Interfaccia Real-time**: Grazie a Livewire, i dati vengono salvati e aggiornati istantaneamente in tutti i report senza mai ricaricare la pagina.
* **📊 Analisi Multicanale**: Non limitarti a un totale. Suddividi i tuoi incassi tra Contanti, POS, Bonifici o qualsiasi altro metodo configurabile.
* **🔍 Controllo Totale**: La "Griglia di Controllo" ti permette di individuare in un secondo i giorni dimenticati o i buchi nella registrazione.
* **🏦 Architettura Professionale**: Utilizza relazioni polimorfiche, il che significa che puoi collegare un registro a un Utente, a un'intera Ditta o a una specifica Filiale senza cambiare una riga di codice.

---

## 🛠 Funzionalità Incluse

### 📝 Editor Giornaliero Smart
Un componente minimalista per inserire le cifre di fine giornata. Include un campo note per segnare anomalie, turni o promemoria importanti.

### 📅 Dettaglio Mensile (Matrix View)
Una tabella avanzata che mostra i giorni del mese sulle righe e i tuoi canali di incasso sulle colonne. Include i totali di riga (giornalieri) e i totali di colonna (mensili per canale).

### 📈 Riepilogo Annuale
Una visione ad alto livello che raggruppa gli incassi mese per mese, ideale per il confronto delle performance stagionali e per la preparazione dei dati per il commercialista.

### 🏁 Griglia di Verifica
Una visualizzazione compatta 1-31 per tutti i 12 mesi dell'anno. Ogni cella indica se il dato è presente, rendendo il "check" di fine mese estremamente rapido.

---

## 🎨 Design Moderno
Il pacchetto è costruito con **Tailwind CSS**, offrendo un look pulito e professionale che si adatta perfettamente alla dashboard di Laravel Breeze o Jetstream. È completamente responsive: controlla i tuoi incassi anche da smartphone mentre sei in viaggio.

---

## 📦 Installazione

Segui questi passaggi per integrare **Artisan Ledger** nel tuo progetto Laravel.

### 1. Requisiti
Assicurati che il tuo progetto utilizzi:
- PHP 8.2 o superiore
- Laravel 10.x o 11.x
- Livewire 3.x

### 2. Installazione tramite Composer
Esegui il comando dalla root del tuo progetto:

```bash
composer require ilbullo/artisan-ledger
```

### 3\. Configurazione del Modello

Il pacchetto utilizza una relazione polimorfica per associare i dati del registro. Aggiungi il trait `HasLedger` al modello che gestirà i corrispettivi (solitamente `User.php`):

PHP

    namespace App\Models;
    
    use Ilbullo\ArtisanLedger\Traits\HasLedger;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable
    {
        use HasLedger;
    
        // ... il resto del tuo modello
    }

### 4\. Database e Migrazioni

Crea le tabelle necessarie (`ledger_days` e `ledger_entries`) eseguendo le migrazioni:

Bash

    php artisan migrate

### 5\. Pubblicazione Asset

Per personalizzare i canali di incasso o lo stile dei componenti, pubblica i file del pacchetto:

**Configurazione (Consigliato)** Serve per definire i tuoi canali (Contanti, POS, ecc.):

Bash

    php artisan vendor:publish --tag="artisan-ledger-config"

**Viste Blade (Opzionale)** Se desideri modificare il design dei componenti (Tailwind CSS):

Bash

    php artisan vendor:publish --tag="artisan-ledger-views"

###   

## 🛠 Setup Post-Installazione

### Configura i tuoi canali

### 

Apri il file `config/artisan-ledger.php` e adatta l'array `channels` alle tue esigenze lavorative:

PHP

    'channels' => [
        'cash' => [
            'label' => 'Contanti',
            'icon'  => 'banknotes',
        ],
        'pos' => [
            'label' => 'POS / Carte',
            'icon'  => 'credit-card',
        ],
        // Aggiungi qui altri canali come 'bonifico', 'assegno', ecc.
    ],

## 🎨 Personalizzazione dei Template (Viste)

Se desideri modificare il design dei componenti per adattarlo perfettamente al tuo tema, puoi pubblicare i file Blade nella cartella delle risorse del tuo progetto.

### 1. Pubblicare le viste
Esegui questo comando nel terminale:

```bash
php artisan vendor:publish --tag="artisan-ledger-views"

### 2\. Dove trovare i file

### 

Dopo l'esecuzione, troverai tutti i template del pacchetto in: `resources/views/vendor/artisan-ledger/`

Qui potrai modificare liberamente:

-   `livewire/ledger-editor.blade.php`: Il form di inserimento.
    
-   `livewire/ledger-monthly-detail.blade.php`: La tabella dei corrispettivi.
    
-   ...e tutti gli altri componenti.
    

### 3\. Note sul Design

### 

I componenti sono costruiti utilizzando **Tailwind CSS**.

-   Se modifichi le classi Tailwind nelle viste pubblicate, assicurati che il tuo file `tailwind.config.js` includa il percorso delle viste vendor per compilare correttamente i nuovi stili:
    

JavaScript

    content: [
        // ... altri percorsi
        "./resources/views/vendor/artisan-ledger/**/*.blade.php",
    ],

> **Nota:** Una volta pubblicate, Laravel darà la precedenza ai file in `resources/views/vendor/artisan-ledger/` rispetto a quelli originali contenuti nel pacchetto.

## 🏷️ Tag dei Componenti

Puoi inserire questi tag in qualsiasi file Blade (es. `resources/views/dashboard.blade.php`). Assicurati che l'utente sia autenticato, poiché il registro è collegato al profilo dell'utente loggato.

### 1. Editor di Inserimento (Giornaliero)
Utilizzato per caricare i dati della giornata selezionata.
```html
<livewire:ledger-editor />

### 2\. Tabella Mensile Dettagliata

### 

Mostra la griglia completa del mese corrente con i totali per ogni canale.

HTML

    <livewire:ledger-monthly-detail />

### 3\. Riepilogo Totali Annuali

### 

Mostra una tabella sintetica con i totali incassati mese per mese.

HTML

    <livewire:ledger-yearly-overview />

### 4\. Griglia di Controllo (Checklist)

### 

Una matrice compatta (mesi/giorni) per individuare rapidamente i giorni senza registrazioni.

HTML

    <livewire:ledger-monthly-grid />

* * *

### Esempio di implementazione rapida

### 

Ecco come potresti organizzare la tua dashboard in Laravel Breeze:

HTML

    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <livewire:ledger-editor />
                </div>
    
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <livewire:ledger-monthly-detail />
                </div>
    
            </div>
        </div>
    </x-app-layout>

<?php

namespace Ilbullo\ArtisanLedger\Livewire;

use Livewire\Component;
use Ilbullo\ArtisanLedger\Facades\Ledger;
use Illuminate\Support\Facades\Auth;

class LedgerEditor extends Component
{
    /**
     * Proprietà pubbliche sincronizzate con il frontend
     */
    public $date;
    public $notes = '';
    public $amounts = []; // Array associativo: ['cash' => 100, 'pos' => 50, ...]

    /**
     * Inizializzazione del componente
     */
    public function mount($date = null)
    {
        // Imposta la data passata o quella odierna
        $this->date = $date ?? now()->format('Y-m-d');

        // Inizializza i dati dal database o dal config
        $this->loadData();
    }

    /**
     * Carica i dati dal database per la data selezionata
     */
    public function loadData()
    {
        $this->amounts = [];

        // Recuperiamo l'intero array dei canali dal config
        $channelsConfig = config('artisan-ledger.channels', []);

        // Usiamo la CHIAVE (es. 'cash', 'pos') per inizializzare gli importi
        foreach ($channelsConfig as $key => $settings) {
            $this->amounts[(string)$key] = 0;
        }

        if (Auth::check()) {
            $day = Auth::user()->ledgerDays()
                ->whereDate('date', $this->date)
                ->with('entries')
                ->first();

            if ($day) {
                $this->notes = $day->notes ?? '';
                foreach ($day->entries as $entry) {
                    $key = (string)$entry->channel_key;
                    // Verifichiamo che la chiave esista ancora nel config attuale
                    if (array_key_exists($key, $this->amounts)) {
                        $this->amounts[$key] = $entry->amount;
                    }
                }
            } else {
                $this->notes = '';
            }
        }
    }

    /**
     * Listener per il cambio data immediato (wire:model.live="date")
     */
    public function updatedDate()
    {
        $this->loadData();
    }

    /**
     * Salva i dati tramite il Service Layer
     */
    public function save()
    {
        // Validazione minima (opzionale, basata sui canali)
        $this->validate([
            'date' => 'required|date',
            'amounts.*' => 'nullable|numeric|min:0',
        ]);

        if (!Auth::check()) {
            session()->flash('error', 'Devi essere loggato per salvare.');
            return;
        }

        try {
            // Utilizziamo la Facade per registrare i dati
            Ledger::record(
                Auth::user(),
                $this->date,
                $this->amounts,
                $this->notes
            );
            //Lanciamo l'evento per aggiornare i componenti
            $this->dispatch('ledger-updated');
            session()->flash('message', 'Corrispettivi salvati con successo per il giorno ' . $this->date);

        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante il salvataggio: ' . $e->getMessage());
        }
    }

    /**
     * Rendering della vista dinamica basata sul tema nel config
     */
    public function render()
    {
        // Recupera il tema dal config (default: 'default')
        $theme = config('artisan-ledger.theme', 'default');

        // Il path punta a: resources/views/themes/{theme}/ledger-editor.blade.php
        return view("artisan-ledger::themes.{$theme}.ledger-editor");
    }
}

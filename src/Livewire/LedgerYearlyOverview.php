<?php

namespace Ilbullo\ArtisanLedger\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Attributes\On;


class LedgerYearlyOverview extends Component
{
    public $year;
    public $channels;

    public function mount($year = null)
    {
        $this->year = $year ?? now()->year;
        $this->channels = config('artisan-ledger.channels', []);
    }

    #[On('ledger-updated')]
    public function render()
    {
        $theme = config('artisan-ledger.theme', 'default');

        // Inizializziamo una collezione vuota per evitare l'errore
        $ledgerData = collect();

        // Verifichiamo se l'utente è autenticato
        if (Auth::check()) {
            $ledgerData = Auth::user()->ledgerDays()
                ->whereYear('date', $this->year)
                ->with('entries')
                ->get()
                ->groupBy(function($day) {
                    // Carbon parse per sicurezza sul formato data
                    return \Carbon\Carbon::parse($day->date)->format('n');
                });
        }

        return view("artisan-ledger::themes.{$theme}.ledger-yearly-overview", [
            'ledgerData' => $ledgerData
        ]);
    }
}

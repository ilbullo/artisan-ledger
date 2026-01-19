<?php

namespace Ilbullo\ArtisanLedger\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Attributes\On;

class LedgerMonthlyDetail extends Component
{
    public $year;
    public $month;
    public $channels;

    public function mount($year = null, $month = null)
    {
        $this->year = $year ?? now()->year;
        $this->month = $month ?? now()->month;
        $this->channels = config('artisan-ledger.channels', []);
    }

    #[On('ledger-updated')]
    public function render()
    {
        $theme = config('artisan-ledger.theme', 'default');
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;

        $ledgerData = [];
        if (Auth::check()) {
            $records = Auth::user()->ledgerDays()
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->with('entries')
                ->get()
                ->keyBy(function($item) {
                    return Carbon::parse($item->date)->day;
                });
        }

        return view("artisan-ledger::themes.{$theme}.ledger-monthly-detail", [
            'records' => $records ?? collect(),
            'daysInMonth' => $daysInMonth
        ]);
    }
}

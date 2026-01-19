<?php

namespace Ilbullo\ArtisanLedger\Services;

use Illuminate\Database\Eloquent\Model;
use Ilbullo\ArtisanLedger\Models\LedgerDay;

class LedgerService
{
    /**
     * Registra i corrispettivi per un modello (User, Sede, ecc.)
     */
    public function record(Model $model, string $date, array $amounts, ?string $notes = null): LedgerDay
    {
        // 1. Trova o crea il giorno per quel soggetto (polimorfico)
        $ledgerDay = $model->ledgerDays()->updateOrCreate(
            ['date' => $date],
            ['notes' => $notes]
        );

        // 2. Sincronizza le entries (i canali)
        foreach ($amounts as $channel => $amount) {
            $ledgerDay->entries()->updateOrCreate(
                ['channel_key' => $channel],
                ['amount' => $amount ?? 0]
            );
        }

        return $ledgerDay;
    }
}

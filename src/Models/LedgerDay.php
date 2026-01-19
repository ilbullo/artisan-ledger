<?php

namespace Ilbullo\ArtisanLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Questo file gestisce la "testata" della giornata (la data e le note)
 */

class LedgerDay extends Model
{
    protected $fillable = ['date', 'notes', 'ledgerable_id', 'ledgerable_type'];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    /**
     * Relazione polimorfica: il "proprietario" del registro.
     */
    public function ledgerable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relazione con i singoli importi divisi per canale.
     */
    public function entries(): HasMany
    {
        return $this->hasMany(LedgerEntry::class);
    }
}

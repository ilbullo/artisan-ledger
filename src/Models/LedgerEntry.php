<?php

namespace Ilbullo\ArtisanLedger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Questo gestisce i singoli importi (es. 100€ in Contanti, 50€ in POS)
 */

class LedgerEntry extends Model
{
    protected $fillable = ['ledger_day_id', 'channel_key', 'amount'];

    protected $casts = [
        'amount' => 'decimal:2',
        'channel_key' => 'string',
    ];

    public function day(): BelongsTo
    {
        return $this->belongsTo(LedgerDay::class, 'ledger_day_id');
    }
}

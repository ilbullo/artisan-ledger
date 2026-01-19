<?php

namespace Ilbullo\ArtisanLedger\Traits;

use Ilbullo\ArtisanLedger\Models\LedgerDay;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLedger
{
    public function ledgerDays(): MorphMany
    {
        return $this->morphMany(LedgerDay::class, 'ledgerable');
    }
}

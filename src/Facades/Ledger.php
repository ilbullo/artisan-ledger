<?php

namespace Ilbullo\ArtisanLedger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Ilbullo\ArtisanLedger\Models\LedgerDay record(\Illuminate\Database\Eloquent\Model $model, string $date, array $amounts, ?string $notes = null)
 * * @see \Ilbullo\ArtisanLedger\LedgerService
 */
class Ledger extends Facade
{
    protected static function getFacadeAccessor()
    {
        // Questo nome deve corrispondere a quello registrato nel ServiceProvider
        return 'artisan-ledger';
    }
}

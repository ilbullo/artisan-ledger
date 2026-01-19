<?php

namespace Ilbullo\ArtisanLedger\Tests\Feature;

use Ilbullo\ArtisanLedger\Tests\TestCase;
use Ilbullo\ArtisanLedger\Models\LedgerDay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User;
use PHPUnit\Framework\Attributes\Test;


class LedgerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_ledger_day_can_be_created()
    {
        // Creiamo l'utente in modo "manuale" per evitare il MassAssignmentException
        $user = new User();
        $user->forceFill([
            'name' => 'Marco',
            'email' => 'marco@example.com',
            'password' => bcrypt('password'),
        ])->save();

        // Ora testiamo l'inserimento nel registro
        $day = LedgerDay::create([
            'ledgerable_id' => $user->id,
            'ledgerable_type' => User::class,
            'date' => '2026-01-19',
            'notes' => 'Test'
        ]);

        $day = LedgerDay::first();
        $this->assertEquals('2026-01-19', $day->date->format('Y-m-d'));
    }
}

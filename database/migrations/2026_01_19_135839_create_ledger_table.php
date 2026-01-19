<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabella Testata: Gestisce il giorno e chi è il proprietario del registro
        Schema::create('ledger_days', function (Blueprint $table) {
            $table->id();
            // Campi polimorfici invece di user_id
            $table->morphs('ledgerable');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indice per evitare doppioni per lo stesso soggetto nella stessa data
            $table->unique(['ledgerable_id', 'ledgerable_type', 'date'], 'ledger_unique_index');
        });

        // Tabella Voci: Gestisce i singoli incassi divisi per canale (cash, pos, ecc.)
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_day_id')->constrained('ledger_days')->onDelete('cascade');
            $table->string('channel_key'); // es. 'cash', 'pos', 'stripe'
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ledger_entries');
        Schema::dropIfExists('ledger_days');
    }
};


1) Aggiungere il trait HasLedger al model User e dirgli di usarlo: 

use Ilbullo\ArtisanLedger\Traits\HasLedger;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasLedger;
    ...


Template personabilizzabile: struttura:
 resources/views/themes/[nome-tema]/
  - ledger-editor.blade.php
  - ledger-monthly-detail.blade.php
  - ledger-yearly-overview.blade.php

  poi in file .env impostare il nome del template 

ARTISAN_LEDGER_THEME = "nome-tema"



Components:
1) <livewire:ledger-monthly-detail /> for month detail
2) <livewire:ledger-yearly-overview /> for yearly view
3) <livewire:ledger-editor :date="request('date')" /> day insert form with optional date parameter 

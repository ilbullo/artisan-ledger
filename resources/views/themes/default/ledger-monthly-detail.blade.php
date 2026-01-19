<div class="max-w-7xl mx-auto my-8 font-sans px-4">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-xl overflow-hidden">

        <div class="px-6 py-5 bg-white border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-600 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">
                        Dettaglio Mensile
                    </h3>
                    <p class="text-sm text-gray-500 capitalize">
                        {{ \Carbon\Carbon::create($year, $month, 1)->locale('it')->translatedFormat('F Y') }}
                    </p>
                </div>
            </div>

            <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                <select wire:model.live="month" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg shadow-sm">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->locale('it')->translatedFormat('F') }}</option>
                    @endforeach
                </select>

                <select wire:model.live="year" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg shadow-sm">
                    @foreach(range(now()->year - 5, now()->year + 1) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-spacing-0">
                <thead>
                    <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="p-4 border-b border-gray-100 w-32">Giorno</th>
                        @foreach($channels as $key => $settings)
                            <th class="p-4 border-b border-gray-100 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <span>{{ $settings['label'] }}</span>
                                </div>
                            </th>
                        @endforeach
                        <th class="p-4 border-b border-gray-100 text-right text-blue-600 bg-blue-50/50">Totale Giorno</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $currentDate = \Carbon\Carbon::create($year, $month, $d)->locale('it');
                            $dayRecord = $records->get($d);
                            $isWeekend = $currentDate->isWeekend();
                            $dayTotal = 0;
                        @endphp
                        <tr class="group hover:bg-blue-50/50 transition-colors {{ $isWeekend ? 'bg-gray-50/30' : '' }}">
                            <td class="p-4 whitespace-nowrap border-r border-gray-50">
                                <div class="flex flex-col">
                                    <span class="font-bold {{ $isWeekend ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $d }}
                                    </span>
                                    <span class="text-[10px] uppercase font-medium {{ $isWeekend ? 'text-red-400' : 'text-gray-400' }}">
                                        {{ $currentDate->translatedFormat('D') }}
                                    </span>
                                </div>
                            </td>

                            @foreach($channels as $key => $settings)
                                @php
                                    $amount = $dayRecord ? $dayRecord->entries->where('channel_key', $key)->first()->amount ?? 0 : 0;
                                    $dayTotal += $amount;
                                @endphp
                                <td class="p-4 text-right font-medium {{ $amount > 0 ? 'text-gray-700' : 'text-gray-300' }}">
                                    @if($amount > 0)
                                        {{ number_format($amount, 2, ',', '.') }} €
                                    @else
                                        <span class="opacity-40">-</span>
                                    @endif
                                </td>
                            @endforeach

                            <td class="p-4 text-right font-bold text-blue-700 bg-blue-50/30 group-hover:bg-blue-100/50">
                                @if($dayTotal > 0)
                                    {{ number_format($dayTotal, 2, ',', '.') }} €
                                @else
                                    <span class="text-blue-300 opacity-40">-</span>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>

                <tfoot class="bg-gray-900 text-white shadow-inner">
                    <tr class="font-bold">
                        <td class="p-5 uppercase tracking-widest text-xs">Totali Mese</td>

                        @php $grandTotal = 0; @endphp
                        @foreach($channels as $key => $settings)
                            @php
                                // Calcoliamo la somma per questa colonna
                                $colSum = $records->sum(fn($r) => $r->entries->where('channel_key', $key)->sum('amount'));
                                $grandTotal += $colSum;
                            @endphp
                            <td class="p-5 text-right border-l border-gray-800">
                                <div class="text-[10px] text-gray-400 font-normal uppercase mb-1">{{ $settings['label'] }}</div>
                                <div class="text-base">{{ number_format($colSum, 2, ',', '.') }} €</div>
                            </td>
                        @endforeach

                        <td class="p-5 text-right bg-blue-900 border-l border-blue-800">
                            <div class="text-[10px] text-blue-300 font-normal uppercase mb-1">Fatturato Totale</div>
                            <div class="text-xl text-yellow-400">{{ number_format($grandTotal, 2, ',', '.') }} €</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
        <p>* I giorni evidenziati in rosso indicano i fine settimana.</p>
        <p>Valuta espressa in Euro (€)</p>
    </div>
</div>

<div class="max-w-7xl mx-auto my-8 font-sans">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Riepilogo Annuale {{ $year }}</h3>
            <div class="flex space-x-2">
                <button wire:click="$set('year', {{ $year - 1 }})" class="p-2 bg-white border rounded-lg hover:bg-gray-100">&larr;</button>
                <span class="px-4 py-2 font-bold">{{ $year }}</span>
                <button wire:click="$set('year', {{ $year + 1 }})" class="p-2 bg-white border rounded-lg hover:bg-gray-100">&rarr;</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b font-bold text-gray-700">Mese</th>
                        @foreach($channels as $key => $settings)
                            <th class="p-4 border-b font-bold text-gray-700 text-right">
                                {{ $settings['label'] }}
                            </th>
                        @endforeach
                        <th class="p-4 border-b font-bold text-blue-700 text-right uppercase tracking-wider">Totale</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                        $channelTotals = array_fill_keys(array_keys($channels), 0);
                    @endphp

                    @for ($m = 1; $m <= 12; $m++)
                        @php
                            $monthDays = $ledgerData->get($m) ?? collect();
                            $monthTotal = 0;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-b font-medium text-gray-900">
                                {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </td>

                            @foreach($channels as $key => $settings)
                                @php
                                    $sum = $monthDays->flatMap->entries->where('channel_key', $key)->sum('amount');
                                    $monthTotal += $sum;
                                    $channelTotals[$key] += $sum;
                                @endphp
                                <td class="p-4 border-b text-right text-gray-600">
                                    {{ number_format($sum, 2, ',', '.') }} €
                                </td>
                            @endforeach

                            <td class="p-4 border-b text-right font-bold text-blue-600 bg-blue-50/30">
                                {{ number_format($monthTotal, 2, ',', '.') }} €
                            </td>
                        </tr>
                        @php $grandTotal += $monthTotal; @endphp
                    @endfor
                </tbody>
                <tfoot>
                    <tr class="bg-gray-900 text-white">
                        <td class="p-4 font-bold uppercase">Totale Annuo</td>
                        @foreach($channels as $key => $settings)
                            <td class="p-4 text-right font-bold">
                                {{ number_format($channelTotals[$key], 2, ',', '.') }} €
                            </td>
                        @endforeach
                        <td class="p-4 text-right font-black text-yellow-400">
                            {{ number_format($grandTotal, 2, ',', '.') }} €
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

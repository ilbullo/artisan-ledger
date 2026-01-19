<div class="max-w-4xl mx-auto my-8 font-sans">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 bg-gray-50 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">
                    🚚 Registro Corrispettivi
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Inserisci gli incassi giornalieri suddivisi per canale.
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="relative">
                    <input type="date"
                           wire:model.live="date"
                           class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-gray-700 shadow-sm">
                </div>
            </div>
        </div>

        <div class="p-6">
            @if (session()->has('message'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-r-lg flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('message') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-r-lg flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($amounts as $channel => $amount)
                    <div class="group">
                        <label for="amount-{{ $channel }}" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            {{ str_replace('_', ' ', $channel) }}
                        </label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <span class="text-sm">€</span>
                            </div>
                            <input type="number"
                                   step="0.01"
                                   id="amount-{{ $channel }}"
                                   wire:model="amounts.{{ $channel }}"
                                   placeholder="0,00"
                                   class="block w-full pl-8 pr-4 py-3 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-gray-900 font-semibold transition-all">
                        </div>
                        @error('amounts.'.$channel) <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-8 border-t border-gray-100">
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                    Note e Osservazioni
                </label>
                <textarea id="notes"
                          wire:model="notes"
                          rows="3"
                          class="block w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm p-3"
                          placeholder="Eventuali note su incassi mancanti o straordinari..."></textarea>
            </div>

            <div class="mt-8 flex items-center justify-between">
                <div class="text-xs text-gray-400 italic">
                    I dati verranno salvati per l'utente loggato.
                </div>
                <button wire:click="save"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-200 disabled:opacity-50">

                    <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    Salva Registro
                </button>
            </div>
        </div>
    </div>
</div>

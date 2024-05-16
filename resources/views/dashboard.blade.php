<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900">
                    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Create User') }}
                    </a>
                    <a href="{{ route('banking.transactions') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Show transactions') }}
                    </a>
                    <a href="{{ route('banking.deposits') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Show deposits') }}
                    </a>

                    <x-secondary-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'deposit-money')"
                >{{ __('Deposit Money') }}</x-secondary-button>

                <a href="{{ route('banking.withdrawals') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Show withdrawals') }}
                </a>

                <x-secondary-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'withdraw-money')"
                >{{ __('Withdraw Money') }}</x-secondary-button>

                </div>


                {{-- deposit modal--}}
                <x-modal name="deposit-money" focusable>
                    <form method="post" action="{{ route('banking.deposit') }}" class="p-6">
                        @csrf


                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Deposit Amount') }}" class="sr-only" />

                            <x-text-input
                                id="amount"
                                name="amount"
                                type="number"
                                class="mt-1 block w-3/4"
                                placeholder="{{ __('Ex: 500') }}"
                            />

                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button class="ms-3">
                                {{ __('Deposit Money') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
                {{-- withdraw modal--}}
                <x-modal name="withdraw-money" focusable>
                    <form method="post" action="{{ route('banking.withdraw.amount') }}" class="p-6">
                        @csrf


                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Withdraw Amount') }}" class="sr-only" />

                            <x-text-input
                                id="amount"
                                name="amount"
                                type="number"
                                class="mt-1 block w-3/4"
                                placeholder="{{ __('Ex: 500') }}"
                            />

                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button class="ms-3">
                                {{ __('Withdraw Money') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </div>
</x-app-layout>

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
			 <div class="col-6 col-12-medium">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                 @if(Session::has('alert-' . $msg))
                                     <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                                           <div class="mt-6 text-gray-900 leading-7 font-semibold ">
                                           <span style="color:green; font-weight:bold;">{{ Session::get('alert-' . $msg) }}</span>
                                           </div>
                                      </div>
                                  @endif
                        @endforeach
                        </div>
                        <br />


        <form method="POST" action="/product-query-save">
            @csrf
		@php if(!empty($_GET['prod_id'])){ $prod_id = $_GET['prod_id'];}else{ $prod_id = 0; } @endphp
		<x-input type="hidden" name="prod_id" value="{{ $prod_id }}" />

            <div>
                <x-label for="text" :value="__('Topic')" />
                <select id="name" class="block mt-5 w-full" name="topic" required autofocus />
			<option> Select The Topic </option>
			<option value="Farming">Farming</option>
			<option value="Utpad-production">Utpad/production</option>
			<option value="Terrace Garden">Terrace Garden</option>
			<option value="Urja-power">Urja/ power</option>
			<option value="Sant sampark">Sant sampark</option>
			<option value="Marketing">Marketing</option>
			<option value="Goshala">Goshala</option>
			<option value="Go chikitsa">Go chikitsa</option>
			<option value="Panchgvya chikitsa">Panchgvya chikitsa</option>
			<option value="Go pariksha">Go pariksha</option>
			<option value="Nidhi-donation">Nidhi /donation</option>
			<option value="Go katha">Go katha</option>
			<option value="Woman interest">Woman interest</option>
			<option value="Other">Other</option>
		</select>
            </div>
		<br />
            <div>
                <x-label for="text" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>
		<br />

            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>
		<br />
            <div>
                <x-label for="city" :value="__('City/Village')" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus />
            </div>
		<br />
            <div>
                <x-label for="city" :value="__('District')" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="district" :value="old('district')" required autofocus />
            </div>
		<br />
            <div>
                <x-label for="message" :value="__('Message')" />
                <textarea id="message" class="block mt-1 w-full"  name="message" :value="old('message')" required autofocus  rows="8" cols="8"/></textarea>
            </div>

		<br />
		<br />
                <x-button class="ml-3">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

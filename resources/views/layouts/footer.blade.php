<div class="bg-sky-800 text-white text-opacity-40 font-semibold uppercase text-xs tracking-widest px-12">
	<div class="container mx-auto grid grid-cols-1 lg:grid-cols-3 gap-16 text-center lg:text-left py-24">
		<div class="flex text-white lg:grow">
			<!-- <div class="text-white opacity-50 text-4xl font-display">{{ __('ITH') }}</div>-->
			<img src="{{ url('Logo.png') }}" class="block h-20 mr-2">
			<p class="mt-11" style="line-height: 10px;"><span style="font-size: 1.5rem;"><b>LPPM-PM</b></span><br><span class="text-sm">Institut Teknologi B.J. Habibie</span></p>
		</div>
		<div class="lg:w-42 lg:flex-none">
			<div class="font-display text-white uppercase text-sm tracking-widest mb-6">{{ __('Informasi Umum') }}</div>
			<p class="flex"><x-heroicon-o-phone class="w-5 h-5 text-white mr-2"/><span>(0421) 2924000</span></p>
			<p class="flex"><x-heroicon-o-mail class="w-5 h-5 text-white mr-2"/><span>lppm-pm@ith.ac.id</span></p><br>
			<p><b class="text-white">Kampus 1:</b> <span>Jl. Balai Kota No. 1 Parepare</span></p>
			<p><b class="text-white">Kampus 2:</b> <span>Jl. Pemuda No. 6 Parepare</span></p>
		</div>
		<div class="lg:w-42 lg:flex-none">
			<div class="font-display text-white uppercase text-sm tracking-widest mb-6">{{ __('Tautan Terkait') }}</div>
			<a href="{{ __('https://ith.ac.id/') }}" class="block mb-4">{{ __('Website ITH') }}</a>
			<a href="{{ __('https://pmb.ith.ac.id/') }}" class="block mb-4">{{ __('PMB ITH') }}</a>
			<a href="{{ __('https://pmb.ith.ac.id/') }}" class="block mb-4">{{ __('BIMA') }}</a>
			<a href="{{ __('https://pmb.ith.ac.id/') }}" class="block mb-4">{{ __('SINTA') }}</a>
			<a href="{{ __('https://pmb.ith.ac.id/') }}" class="block mb-4">{{ __('ARJUNA') }}</a>
			<a href="{{ __('https://pmb.ith.ac.id/') }}" class="block mb-4">{{ __('GARUDA') }}</a>
			<a href="{{ __('https://pmb.ith.ac.id/') }}" class="block mb-4">{{ __('RAMA') }}</a>
		</div>
	</div>
	<div class="text-sm lg:text-base text-center font-heading font-light tracking-widest uppercase text-white opacity-75 pb-24">
		{{ __('©2022 TIM LPPM-PM. INSTITUT TEKNOLOGI B.J. HABIBIE') }}
	</div>
</div>

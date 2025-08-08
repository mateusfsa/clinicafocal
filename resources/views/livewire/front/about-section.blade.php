<!-- About Section -->
<section id="sobre" class="py-20 bg-white">
    <div class="container mx-auto px-5 flex flex-col lg:flex-row items-center gap-12">
        <div class="flex-1 rounded-xl overflow-hidden shadow-custom">
            @if ($aboutImage)
                <img src="{{ asset('storage/' . $aboutImage) }}" alt="Sobre a Clínica Focal">
            @else
                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80"
                    alt="Clínica Focal">
            @endif
        </div>
        <div class="flex-1">
            <h2 class="font-montserrat font-bold text-3xl mb-6">{{ $title ?? 'Sobre a Nossa Clínica' }}</h2>
            <div>
                <p class="text-gray-600 mb-6">{!! $description_1 ??
                    'Fundada em 2005, a Clínica Focal é referência em oftalmologia, oferecendo tratamentos de ponta com profissionais altamente qualificados. Nossa missão é proporcionar saúde ocular com excelência e humanização.' !!}</p>
                <p class="text-gray-600 mb-6"> {!! $description_2 ??
                    'Com unidades modernas e equipamentos de última geração, garantimos diagnósticos precisos e tratamentos eficazes para diversas condições oculares.' !!}</p>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-8">
                @foreach ($features as $feature)
                    <div class="flex gap-4">
                        <div
                            class="feature-icon w-14 h-14 rounded-full bg-light flex items-center justify-center text-primary text-xl flex-shrink-0">
                            <i class="{{ $feature->icon }}"></i>
                        </div>
                        <div>
                            <h4 class="font-montserrat font-bold text-dark mb-1">{{ $feature->title }}</h4>
                            <p class="text-gray-600">{{ $feature->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

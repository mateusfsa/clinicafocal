<section id="servicos" class="py-20 bg-light">
    <div class="container mx-auto px-5">
        <h2 class="section-title font-montserrat font-bold text-3xl md:text-4xl text-center relative mb-6">Nossos
            Serviços</h2>
        <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-12">Oferecemos tratamentos oftalmológicos
            completos para todas as idades e necessidades</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
            @foreach ($services as $service)
                <div
                    class="service-card bg-white rounded-xl overflow-hidden shadow-custom transition-all hover:-translate-y-2.5 hover:shadow-card-hover">
                    <div class="service-image h-48 overflow-hidden">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                class="w-full h-full object-cover transition-all hover:scale-110">
                        @else
                            <img src="https://images.unsplash.com/photo-1588776813677-77d08c4ce13a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="{{ $service->title }}"
                                class="w-full h-full object-cover transition-all hover:scale-110">
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-montserrat font-bold text-xl text-primary mb-4">{{ $service->title }}</h3>
                        <p class="text-gray-600 mb-5">{{ $service->description }}</p>
                        <a href="{{ $service->link }}"
                            class="btn-outline px-6 py-2.5 border-2 border-primary rounded-full no-underline font-semibold uppercase tracking-wider text-sm shadow-custom transition-all hover:bg-primary hover:text-white">Saiba
                            Mais</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

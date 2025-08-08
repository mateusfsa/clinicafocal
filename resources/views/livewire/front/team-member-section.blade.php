<section id="equipe" class="py-20">
    <div class="container mx-auto px-5">
        <h2 class="section-title font-montserrat font-bold text-3xl md:text-4xl text-center relative mb-6">Nossa
            Equipe</h2>
        <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-12">Profissionais altamente qualificados
            dedicados ao cuidado da sua visão</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
            @foreach ($members as $member)
                <div class="team-member bg-white rounded-xl overflow-hidden shadow-custom text-center">
                    <div class="member-image h-72 overflow-hidden">
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="member-info p-6">
                        <h3 class="font-montserrat font-bold text-xl mb-1">{{ $member->name }}</h3>
                        <span class="text-primary font-semibold block mb-2">{{ $member->role }}</span>
                        <p class="text-gray-600">{{ $member->crm }}</p>
                        <div class="flex justify-center gap-4 mt-4">
                            <a href="#"
                                class="w-9 h-9 rounded-full bg-light flex items-center justify-center text-primary transition-all hover:bg-primary hover:text-white hover:-translate-y-1">
                                <i class="fab fa-linkedin-in">{{ $member->linkedin }}</i>
                            </a>
                            <a href="#"
                                class="w-9 h-9 rounded-full bg-light flex items-center justify-center text-primary transition-all hover:bg-primary hover:text-white hover:-translate-y-1">
                                <i class="fab fa-instagram">{{ $member->instagram }}</i>
                            </a>
                            <a href="#"
                                class="w-9 h-9 rounded-full bg-light flex items-center justify-center text-primary transition-all hover:bg-primary hover:text-white hover:-translate-y-1">
                                <i class="far fa-envelope">{{ $member->email }}</i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

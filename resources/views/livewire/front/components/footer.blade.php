<footer class="bg-dark text-white pt-16 pb-5">
    <div class="container mx-auto px-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div class="footer-col">
                <div class="font-montserrat font-bold text-2xl text-white mb-5"> {!! get_option('title_site') !!} </div>
                <p class="text-gray-400 mb-5">{{ $about->description_1 }}</p>
                <div class="footer-social flex gap-4 mt-5">
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white transition-all hover:bg-primary hover:-translate-y-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white transition-all hover:bg-primary hover:-translate-y-1">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white transition-all hover:bg-primary hover:-translate-y-1">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white transition-all hover:bg-primary hover:-translate-y-1">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <h3 class="font-montserrat font-bold text-xl mb-6 pb-2 relative">Links Rápidos</h3>
                <ul class="footer-links space-y-3">
                    @foreach ($menuItems as $item)
                        <li><a href="{{ $item->url }}"
                                class="text-gray-400 no-underline transition-all hover:text-accent hover:pl-1.5">{{ $item->label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-col">
                <h3 class="font-montserrat font-bold text-xl mb-6 pb-2 relative">Nossos Serviços</h3>
                <ul class="footer-links space-y-3">
                    @foreach ($services as $service)
                        <option value=""></option>
                        <li><a href="{{ $service->link }}"
                                class="text-gray-400 no-underline transition-all hover:text-accent hover:pl-1.5">{{ $service->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-col">
                <h3 class="font-montserrat font-bold text-xl mb-6 pb-2 relative">Newsletter</h3>
                <p class="text-gray-400 mb-5">Inscreva-se para receber dicas de saúde ocular e novidades da
                    clínica.</p>
                <form>
                    <div class="mb-3">
                        <input type="email" placeholder="Seu Email"
                            class="w-full px-4 py-3 rounded-lg border-none focus:outline-none">
                    </div>
                    <button type="submit"
                        class="btn px-6 py-3 bg-primary text-white rounded-full no-underline font-semibold uppercase tracking-wider text-sm shadow-custom transition-all hover:bg-secondary hover:-translate-y-1 hover:shadow-custom-hover w-full">Inscrever-se</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom pt-5 border-t border-white/10 text-center text-gray-400 text-sm">
            <p>&copy; {{ get_option('footer_text') }}</p>
        </div>
    </div>
</footer>

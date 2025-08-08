 @if ($hero)
     <section id="inicio"
         class="min-h-screen flex items-center text-white pt-16 bg-gradient-to-br from-primary/90 to-secondary/90 bg-[url('https://images.unsplash.com/photo-1504813184591-01572f98c85f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80')] bg-cover bg-center bg-no-repeat"
         style="background-image:url({{$hero->background_image ? asset('storage/'.$hero->background_image) : 'https://images.unsplash.com/photo-1504813184591-01572f98c85f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80' }});">
         <div class="container mx-auto px-5">
             <div class="max-w-2xl">
                 <h1 class="font-montserrat font-bold text-4xl md:text-5xl leading-tight mb-6">{{ $hero->title }}</h1>
                 <p class="text-lg md:text-xl opacity-90 mb-8">{{ $hero->subtitle }}</p>
                 <div class="flex flex-col sm:flex-row gap-5">
                     <a href="{{ $hero->button1_link }}"
                         class="btn px-8 py-3.5 bg-primary text-white rounded-full no-underline font-semibold uppercase tracking-wider text-sm shadow-custom transition-all hover:bg-secondary hover:-translate-y-1 hover:shadow-custom-hover">{{ $hero->button1_text }}</a>
                     <a href="{{ $hero->button2_link }}"
                         class="btn-outline px-8 py-3.5 border-2 border-primary rounded-full no-underline font-semibold uppercase tracking-wider text-sm shadow-custom transition-all hover:bg-primary hover:text-white">{{ $hero->button2_text }}</a>
                 </div>
             </div>
         </div>
     </section>
 @endif

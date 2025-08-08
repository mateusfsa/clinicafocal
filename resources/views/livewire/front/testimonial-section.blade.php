 <section id="depoimentos" class="py-20 bg-gradient-to-r from-primary to-secondary text-white">
     <div class="container mx-auto px-5">
         <h2 class="section-title font-montserrat font-bold text-3xl md:text-4xl text-center relative mb-6">Depoimentos
         </h2>
         <p class="text-lg opacity-80 text-center max-w-3xl mx-auto mb-12">O que nossos pacientes dizem sobre nosso
             atendimento</p>

         <div class="max-w-4xl mx-auto">
             @foreach ($testimonials as $item)
                 <div class="testimonial-slide bg-white/10 p-10 rounded-xl my-8 text-center backdrop-blur">
                     <p class="testimonial-text text-lg italic mb-8 relative">{{ $item->testimonial }}</p>
                     <div class="testimonial-author flex items-center justify-center gap-4">
                         <div class="author-image w-14 h-14 rounded-full overflow-hidden border-2 border-accent">
                             <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                 class="w-full h-full object-cover">
                         </div>
                         <div class="author-info text-left">
                             <h4 class="font-montserrat font-bold text-white">{{ $item->name }}</h4>
                             <p class="opacity-80">{{ $item->role }}</p>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
     </div>
 </section>

 @push('scripts')
     <script>
         let currentTestimonial = 0;
         const testimonialSlide = document.querySelector('.testimonial-slide');

         function rotateTestimonials() {
             currentTestimonial = (currentTestimonial + 1) % testimonials.length;
             updateTestimonial();
         }

         function updateTestimonial() {
             const testimonial = testimonials[currentTestimonial];
             testimonialSlide.innerHTML = `
                <p class="testimonial-text text-lg italic mb-8 relative">${testimonial.text}</p>
                <div class="testimonial-author flex items-center justify-center gap-4">
                    <div class="author-image w-14 h-14 rounded-full overflow-hidden border-2 border-accent">
                        <img src="${testimonial.image}" alt="${testimonial.author}" class="w-full h-full object-cover">
                    </div>
                    <div class="author-info text-left">
                        <h4 class="font-montserrat font-bold text-white">${testimonial.author}</h4>
                        <p class="opacity-80">${testimonial.role}</p>
                    </div>
                </div>
            `;
         }

         // Change testimonial every 5 seconds
         setInterval(rotateTestimonials, 5000);

         // Initialize
         updateTestimonial();
     </script>
 @endpush

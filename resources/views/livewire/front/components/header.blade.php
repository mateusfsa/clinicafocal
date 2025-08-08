 <header class="bg-white shadow-custom fixed w-full top-0 z-50">
     <div class="container mx-auto px-5 flex justify-between items-center py-4">
         <div class="logo flex items-center">
             <img src="{{ asset('storage/' . get_option('logo_site')) }}" alt="" class="h-10">
             <div class="font-montserrat font-bold dark:text-cyan-300 text-2xl px-2">
                 {!! get_option('title_site') !!}                 
             </div>
         </div>
         <nav>
             <ul class="hidden md:flex space-x-4">
                 @foreach ($menuItems as $item)
                     <li><a href="{{ $item->url }}"
                             class="nav-link relative font-semibold text-dark py-1 transition-all">{{ $item->label }}</a>
                     </li>
                 @endforeach
             </ul>
             <button class="md:hidden bg-transparent border-none text-2xl cursor-pointer text-dark">
                 <i class="fas fa-bars"></i>
             </button>
         </nav>
     </div>
 </header>

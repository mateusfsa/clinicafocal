 <div>
     <form wire:submit.prevent="enviarEmail">
         <div class="mb-5">
             <input type="text" wire:model="name" placeholder="Nome Completo" required
                 class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
             @error('name')
                 <span class="text-red-500 text-xs">{{ $message }}</span>
             @enderror
         </div>
         <div class="mb-5">
             <input type="email" wire:model="email" placeholder="Email" required
                 class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
             @error('email')
                 <span class="text-red-500 text-xs">{{ $message }}</span>
             @enderror
         </div>
         <div class="mb-5">
             <input type="tel" wire:model="phone"placeholder="Telefone" required
                 class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
             @error('phone')
                 <span class="text-red-500 text-xs">{{ $message }}</span>
             @enderror
         </div>
         <div class="mb-5">
             <select required wire:model="service"
                 class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                 <option value="" disabled selected>Selecione um serviço</option>
                 @foreach ($services as $service)
                     <option value="{{ $service->link }}">{{ $service->title }}</option>
                 @endforeach
             </select>
             @error('service')
                 <span class="text-red-500 text-xs">{{ $message }}</span>
             @enderror
         </div>
         <div class="mb-5">
             <textarea placeholder="Mensagem" wire:model="mensage" required
                 class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base h-36 focus:border-primary focus:outline-none resize-y"></textarea>
             @error('mensage')
                 <span class="text-red-500 text-xs">{{ $message }}</span>
             @enderror
         </div>
         <button type="submit"
             class="btn px-8 py-3.5 bg-primary text-white rounded-full no-underline font-semibold uppercase tracking-wider text-sm shadow-custom transition-all hover:bg-secondary hover:-translate-y-1 hover:shadow-custom-hover w-full">Enviar
             Mensagem</button>
     </form>
 </div>

<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Configurações do Site</h1>
                    @if ($successMessage)
                        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                            {{ $successMessage }}
                        </div>
                    @endif
                    <form wire:submit.prevent="save" class="grid gap-4 max-w-xl">
                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Header</h3>
                            <div>
                                <label for="title_site" class="block text-sm font-medium text-gray-700">Título do
                                    Site</label>
                                <input id="title_site" type="text" wire:model.defer="settings.title_site"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="logo_site" class="block text-sm font-medium text-gray-700">Logo
                                    (URL)</label>
                                <input id="logo_site" type="file" wire:model.defer="settings.logo_site"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @if ($settings['logo_site'])
                                    <img src="{{ asset('storage' . $settings['logo_site']) }}" alt="Logo"
                                        class="h-16 mt-2">
                                @endif
                            </div>
                        </div>
                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Seção Sobre</h3>
                            <div>
                                <label for="about_section_title" class="block text-sm font-medium text-gray-700">Título
                                    da
                                    Seção Sobre</label>
                                <input id="about_section_title" type="text"
                                    wire:model.defer="settings.about_section_title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label for="about_section_description"
                                    class="block text-sm font-medium text-gray-700">Descrição da Seção
                                    Sobre</label>
                                <textarea id="about_section_description" wire:model.defer="settings.about_section_description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                        </div>
                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Seção Serviços</h3>
                            <div>
                                <label for="service_section_title"
                                    class="block text-sm font-medium text-gray-700">Título da
                                    Seção Serviços</label>
                                <input id="service_section_title" type="text"
                                    wire:model.defer="settings.service_section_title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="service_section_subtitle"
                                    class="block text-sm font-medium text-gray-700">Subtítulo da Seção
                                    Serviços</label>
                                <input id="service_section_subtitle" type="text"
                                    wire:model.defer="settings.service_section_subtitle"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Seção Equipe</h3>
                            <div>
                                <label for="team_section_title" class="block text-sm font-medium text-gray-700">Título
                                    da
                                    Seção Equipe</label>
                                <input id="team_section_title" type="text"
                                    wire:model.defer="settings.team_section_title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="team_section_subtitle"
                                    class="block text-sm font-medium text-gray-700">Subtítulo
                                    da Seção Equipe</label>
                                <input id="team_section_subtitle" type="text"
                                    wire:model.defer="settings.team_section_subtitle"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Seção Depoimentos</h3>
                            <div>
                                <div>
                                    <label for="testimonial_section_title"
                                        class="block text-sm font-medium text-gray-700">Título da Seção
                                        Depoimentos</label>
                                    <input id="testimonial_section_title" type="text"
                                        wire:model.defer="settings.testimonial_section_title"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="testimonial_section_subtitle"
                                        class="block text-sm font-medium text-gray-700">Subtítulo da Seção
                                        Depoimentos</label>
                                    <input id="testimonial_section_subtitle" type="text"
                                        wire:model.defer="settings.testimonial_section_subtitle"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Seção Contato</h3>
                            <div>
                                <label for="contact_section_title"
                                    class="block text-sm font-medium text-gray-700">Título da
                                    Seção Contato</label>
                                <input id="contact_section_title" type="text"
                                    wire:model.defer="settings.contact_section_title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="contact_section_subtitle"
                                    class="block text-sm font-medium text-gray-700">Subtítulo da Seção
                                    Contato</label>
                                <input id="contact_section_subtitle" type="text"
                                    wire:model.defer="settings.contact_section_subtitle"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="contact_section_address"
                                    class="block text-sm font-medium text-gray-700">Endereço</label>
                                <textarea id="contact_section_address" wire:model.defer="settings.contact_section_address"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                            <div>
                                <label for="contact_section_phone"
                                    class="block text-sm font-medium text-gray-700">Telefone</label>
                                <input id="contact_section_phone" type="text"
                                    wire:model.defer="settings.contact_section_phone"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="contact_section_email"
                                    class="block text-sm font-medium text-gray-700">E-mail</label>
                                <input id="contact_section_email" type="email"
                                    wire:model.defer="settings.contact_section_email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="contact_section_time_1"
                                    class="block text-sm font-medium text-gray-700">Horário
                                    1</label>
                                <input id="contact_section_time_1" type="text"
                                    wire:model.defer="settings.contact_section_time_1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="contact_section_time_2"
                                    class="block text-sm font-medium text-gray-700">Horário 2</label>
                                <input id="contact_section_time_2" type="text"
                                    wire:model.defer="settings.contact_section_time_2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp</label>
                                <input id="whatsapp" type="text" wire:model.defer="settings.whatsapp"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="footer_text" class="block text-sm font-medium text-gray-700">Texto do
                                    Rodapé</label>
                                <input id="footer_text" type="text" wire:model.defer="settings.footer_text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="w-full border p-2 rounded-md">
                            <h3 class="text-xl font-medium mb-4">Redes Sociais</h3>
                            <div>
                                <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook</label>
                                <input id="facebook" type="text" wire:model.defer="settings.facebook"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="instagram"
                                    class="block text-sm font-medium text-gray-700">Instagram</label>
                                <input id="instagram" type="text" wire:model.defer="settings.instagram"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="linkedin" class="block text-sm font-medium text-gray-700">Linkedin</label>
                                <input id="linkedin" type="text" wire:model.defer="settings.linkedin"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-800 mt-2">
                            Salvar Configurações
                        </button>
                    </form>
            </div>
        </div>
    </div>
</div>

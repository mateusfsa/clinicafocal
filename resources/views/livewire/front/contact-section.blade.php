   <section id="contato" class="py-20">
        <div class="container mx-auto px-5">
            <h2 class="section-title font-montserrat font-bold text-3xl md:text-4xl text-center relative mb-6">
                {{ get_option('contact_section_title') }}</h2>
            <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-12">
                {{ get_option('contact_section_subtitle') }}</p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="contact-info flex flex-col gap-6">
                    <div class="contact-item flex gap-4">
                        <div
                            class="contact-icon w-12 h-12 rounded-full bg-light flex items-center justify-center text-primary text-lg flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4 class="font-montserrat font-bold text-dark mb-1">Endereço</h4>
                            <p class="text-gray-600">{{ get_option('contact_section_address') }}</p>
                        </div>
                    </div>

                    <div class="contact-item flex gap-4">
                        <div
                            class="contact-icon w-12 h-12 rounded-full bg-light flex items-center justify-center text-primary text-lg flex-shrink-0">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4 class="font-montserrat font-bold text-dark mb-1">Telefone</h4>
                            <p class="text-gray-600">{{ get_option('contact_section_phone') }}</p>
                            <p class="text-gray-600">{{ get_option('whatsapp') }} (WhatsApp)</p>
                        </div>
                    </div>

                    <div class="contact-item flex gap-4">
                        <div
                            class="contact-icon w-12 h-12 rounded-full bg-light flex items-center justify-center text-primary text-lg flex-shrink-0">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h4 class="font-montserrat font-bold text-dark mb-1">Email</h4>
                            <p class="text-gray-600">{{ get_option('contact_contact_section_email') }}</p>
                        </div>
                    </div>

                    <div class="contact-item flex gap-4">
                        <div
                            class="contact-icon w-12 h-12 rounded-full bg-light flex items-center justify-center text-primary text-lg flex-shrink-0">
                            <i class="far fa-clock"></i>
                        </div>
                        <div class="contact-content">
                            <h4 class="font-montserrat font-bold text-dark mb-1">Horário de Funcionamento</h4>
                            <p class="text-gray-600">{{ get_option('contact_contact_section_time_1') }}</p>
                            <p class="text-gray-600">{{ get_option('contact_contact_section_time_2') }}</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                   <livewire:front.components.form-contact>
                </div>
            </div>
        </div>
    </section>
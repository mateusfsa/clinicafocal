<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-6">Painel de Controle</h1>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <livewire:admin.components.dashboard-visit-counter />
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

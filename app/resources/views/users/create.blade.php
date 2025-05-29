<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-950 px-4 py-12 relative">
        <div class="w-full max-w-md relative -top-24">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">Registrar Nuevo Usuario</h2>
            @include('users.partials._form', ['action' => route('user.store'), 'method' => 'POST'])
        </div>
    </div>
</x-app-layout>

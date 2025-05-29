<form action="{{ $action }}" method="POST"
    class="space-y-6 bg-white dark:bg-gray-900 p-8 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
            class="w-full px-4 py-2 mt-1 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring focus:ring-indigo-300" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
            class="w-full px-4 py-2 mt-1 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring focus:ring-indigo-300" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
        <input type="password" name="password" required
            class="w-full px-4 py-2 mt-1 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring focus:ring-indigo-300" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" required
            class="w-full px-4 py-2 mt-1 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring focus:ring-indigo-300" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
        <select name="roles[]" multiple
            class="w-full px-4 py-2 mt-1 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring focus:ring-indigo-300">
            @foreach (Spatie\Permission\Models\Role::all() as $role)
                @if (auth()->user()->hasRole('admin') || $role->name !== 'admin')
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div>
        <button type="submit"
            class="block w-full !bg-indigo-600 !text-white !py-2 !px-4 !rounded-md !shadow-md !text-base !font-bold !block !opacity-100 !visible !z-50">
            Registrar
        </button>


    </div>
</form>

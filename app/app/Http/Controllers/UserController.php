<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        if (Auth::check() && $authUser->hasRole('secre')) {
            $roles = $roles->filter(fn($role) => $role->name !== 'admin');
        }

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required',
                'string',
                'lowercase',
                'email:rfc',
                'max:255',
                'regex:/^[A-Za-z0-9._%+-]+@espe\.edu\.ec$/',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles'    => ['required', 'array'],
            'roles.*'  => ['string', 'exists:roles,name'],
        ], [
            'email.regex' => 'El correo debe pertenecer al dominio @espe.edu.ec',
        ]);

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        if ($authUser->hasRole('secre') && in_array('admin', $request->roles)) {
            return redirect()->back()->withErrors(['roles' => 'No puedes asignar el rol de administrador.']);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);
        event(new Registered($user));

        return redirect()->route('user.index')->with('success', 'Usuario registrado correctamente');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc',
                'max:255',
                'regex:/^[A-Za-z0-9._%+-]+@espe\.edu\.ec$/',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'roles'   => ['required', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success', 'Usuario actualizado correctamente');
    }
}

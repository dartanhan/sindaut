<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $usuarios = User::orderBy('id', 'desc')->get();

            return view('admin.usuario', compact('user_data', 'usuarios'));
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            return view('admin.usuario_create', compact('user_data'));
        }
        return redirect()->route('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma cadeia de caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Insira um e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput()->with('danger', $error);
        }

        $usuario = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        if (empty($usuario)) {
            return redirect()->route('usuario.index')->with('danger', 'Não foi possível cadastrar o usuário.');
        }

        return redirect()->route('usuario.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $usuario = User::find($id);

            if (!$usuario) {
                abort(404);
            }

            return view('admin.usuario_edit', compact('user_data', 'usuario'));
        }
        return redirect()->route('admin.login');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect()->route('usuario.index')->with('danger', 'Usuário não encontrado.');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma cadeia de caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Insira um e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.min' => 'A nova senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->back()->withInput()->with('danger', $error);
        }

        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->input('password'));
        }

        $atualizacaoBemSucedida = $usuario->update();

        if (!$atualizacaoBemSucedida) {
            return redirect()->route('usuario.index')->with('danger', 'Erro ao atualizar o usuário.');
        }

        return redirect()->route('usuario.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuário não encontrado.'], 404);
        }

        // Impede que o próprio usuário logado se exclua
        if ($usuario->id === auth()->user()->id) {
            return response()->json(['success' => false, 'message' => 'Você não pode excluir sua própria conta.'], 400);
        }

        $usuario->delete();

        return response()->json(['success' => true, 'message' => 'Usuário excluído com sucesso.']);
    }
}

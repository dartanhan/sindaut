@extends('layouts.admin')

@section('title', 'Usuários')
@section('header_title', 'Usuários')
@section('header_subtitle', 'Gerenciamento de usuários que acessam o painel administrativo')

@section('header_actions')
<a href="{{ route('usuario.create') }}" class="bg-blue-600 hover:bg-slate-900 text-white font-black px-8 py-4 rounded-2xl transition shadow-xl shadow-blue-600/20 text-xs tracking-widest flex items-center gap-3 uppercase">
    <i data-lucide="plus-circle" class="w-5 h-5"></i>
    Cadastrar Usuário
</a>
@endsection

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/70">
                    <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Nome</th>
                    <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">E-mail</th>
                    <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Criado Em</th>
                    <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Atualizado Em</th>
                    <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($usuarios as $item)
                    <tr class="hover:bg-slate-100/50 transition">
                        <td class="p-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ substr($item->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-bold text-slate-700">
                                    {{ $item->name }}
                                </div>
                            </div>
                        </td>
                        <td class="p-8 text-sm font-medium text-slate-500">
                            {{ $item->email }}
                        </td>
                        <td class="p-8 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ $item->created_at ?: '-' }}
                        </td>
                        <td class="p-8 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ $item->updated_at ?: '-' }}
                        </td>
                        <td class="p-8">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('usuario.edit', $item->id) }}" class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition shadow-sm" title="Editar Usuário">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                @if($item->id !== auth()->user()->id)
                                    <button type="button" 
                                            class="w-10 h-10 bg-white border border-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition shadow-sm btn-excluir"
                                            data-rota="{{ route('usuario.destroy', $item->id) }}"
                                            title="Excluir Usuário">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-16 text-center text-slate-400 font-bold text-sm">
                            <div class="flex flex-col items-center gap-3">
                                <i data-lucide="users" class="w-10 h-10 text-slate-300"></i>
                                Nenhum usuário cadastrado.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Manipula exclusão via AJAX
        $('.btn-excluir').on('click', function() {
            const rota = $(this).data('rota');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Atenção!',
                text: "Tem certeza que deseja excluir este usuário?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase tracking-widest',
                    cancelButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: rota,
                        type: 'DELETE',
                        headers: {
                            'X-CSR-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#3b82f6',
                                    customClass: {
                                        popup: 'rounded-[2rem]'
                                    }
                                });
                                row.fadeOut(400, function() {
                                    row.remove();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erro!',
                                    text: response.message || 'Ocorreu um erro ao excluir o usuário.',
                                    icon: 'error',
                                    confirmButtonColor: '#3b82f6',
                                    customClass: {
                                        popup: 'rounded-[2rem]'
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Falha na comunicação com o servidor.';
                            Swal.fire({
                                title: 'Erro!',
                                text: errorMsg,
                                icon: 'error',
                                confirmButtonColor: '#3b82f6',
                                customClass: {
                                    popup: 'rounded-[2rem]'
                                }
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

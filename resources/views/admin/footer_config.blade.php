@extends('layouts.admin')

@section('title', 'Configuração do Rodapé')
@section('header_title', 'Rodapé')
@section('header_subtitle', 'Gerencie as informações de contato, redes sociais e logo exibidas no rodapé do portal')

@section('header_actions')
<button form="footerForm" type="submit" id="btnSubmit"
    class="bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-3 rounded-2xl transition shadow-xl shadow-blue-600/20 text-sm flex items-center gap-2">
    <i data-lucide="save" class="w-4 h-4"></i>
    <span id="btnText">SALVAR ALTERAÇÕES</span>
    <div id="btnLoader" class="hidden">
        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</button>
@endsection

@push('styles')
<style>
    .tab-btn {
        padding: 10px 24px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all .2s;
        white-space: nowrap;
    }
    .tab-btn.active {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 4px 15px rgba(37,99,235,.3);
    }
    .tab-btn:hover:not(.active) {
        color: #1e293b;
        background: #f1f5f9;
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* Drop zone logo */
    .logo-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        background: #f8fafc;
    }
    .logo-dropzone:hover, .logo-dropzone.dragover {
        border-color: #2563eb;
        background: #eff6ff;
    }
    .logo-dropzone input[type="file"] { display: none; }

    /* Campo de setor */
    .setor-field-label {
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 4px;
    }
    .field-input {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        transition: all .2s;
        outline: none;
    }
    .field-input:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }
    .field-textarea {
        resize: vertical;
        min-height: 90px;
    }
    .remove-setor-btn {
        background: #fef2f2;
        border: none;
        color: #ef4444;
        border-radius: 10px;
        padding: 8px 10px;
        cursor: pointer;
        transition: background .2s;
        flex-shrink: 0;
    }
    .remove-setor-btn:hover { background: #fee2e2; }
    .add-setor-btn {
        border: 1.5px dashed #2563eb;
        background: transparent;
        color: #2563eb;
        border-radius: 14px;
        padding: 12px 22px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all .2s;
    }
    .add-setor-btn:hover { background: #eff6ff; }
    .section-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 24px;
        padding: 32px;
    }
    .section-title {
        font-size: 17px;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 24px;
    }
    .field-group { margin-bottom: 18px; }
    .icon-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #2563eb;
        margin-bottom: 6px;
    }
    .icon-label svg { width: 14px; height: 14px; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 p-5 rounded-2xl mb-6 font-bold space-y-1">
            <div class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-5 h-5"></i> Corrija os erros abaixo:</div>
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- ABAS --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-2 flex gap-1 mb-6 overflow-x-auto">
        <button type="button" class="tab-btn active" onclick="switchTab('logo')">Logo e Redes Sociais</button>
        <button type="button" class="tab-btn" onclick="switchTab('fale')">Fale Conosco</button>
        <button type="button" class="tab-btn" onclick="switchTab('sede')">Sede (Atendimento)</button>
        <button type="button" class="tab-btn" onclick="switchTab('subsede')">Subsede</button>
    </div>

    <form id="footerForm" action="{{ route('footer-config.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- =============================== ABA 1: LOGO & REDES =============================== --}}
        <div id="tab-logo" class="tab-panel active">
            <div class="section-card">
                <div class="section-title">Logo e Redes Sociais</div>

                {{-- Logo --}}
                <div class="field-group">
                    <div class="setor-field-label">LOGO DO RODAPÉ</div>
                    <div class="flex items-start gap-2 mb-3 p-3 bg-blue-50 rounded-xl">
                        <i data-lucide="info" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                        <p class="text-xs text-blue-700">
                            <strong>Dimensões recomendadas: 200 x 60 pixels</strong>. Formatos: JPEG, PNG, JPG, GIF ou WEBP. Máx: 2MB.
                            Deixe vazio se não quiser alterar o logo atual.
                        </p>
                    </div>

                    <div class="logo-dropzone" id="logoDropzone" onclick="document.getElementById('logoInput').click()">
                        <input type="file" name="logo" id="logoInput" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <i data-lucide="upload-cloud" class="w-10 h-10 text-slate-400 mx-auto mb-3"></i>
                        <p class="font-black text-sm text-slate-600 uppercase tracking-widest">CLIQUE PARA SELECIONAR NOVO LOGO</p>
                        <p class="text-xs text-slate-400 mt-1">ou arraste e solte o arquivo de imagem aqui</p>
                    </div>
                </div>

                {{-- Preview do logo atual --}}
                @if($footer->logo_path)
                <div class="field-group">
                    <div class="setor-field-label">LOGO ATUAL / PRÉ-VISUALIZAÇÃO</div>
                    <div class="bg-slate-900 rounded-2xl p-8 flex items-center justify-center min-h-[100px]" id="logoPreviewBox">
                        <img src="{{ asset('storage/footer/' . $footer->logo_path) }}" alt="Logo atual" id="logoPreviewImg" class="max-h-16 object-contain">
                    </div>
                </div>
                @else
                <div class="field-group" id="logoPreviewArea" style="display:none">
                    <div class="setor-field-label">LOGO ATUAL / PRÉ-VISUALIZAÇÃO</div>
                    <div class="bg-slate-900 rounded-2xl p-8 flex items-center justify-center min-h-[100px]" id="logoPreviewBox">
                        <img src="" alt="Logo preview" id="logoPreviewImg" class="max-h-16 object-contain">
                    </div>
                </div>
                @endif

                <hr class="my-6 border-slate-100">

                {{-- Redes Sociais --}}
                @php $redes = $footer->redes_sociais ?? []; @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="field-group">
                        <div class="setor-field-label">FACEBOOK URL</div>
                        <input type="url" name="redes_sociais[facebook]" class="field-input"
                            value="{{ old('redes_sociais.facebook', $redes['facebook'] ?? '') }}"
                            placeholder="#">
                    </div>
                    <div class="field-group">
                        <div class="setor-field-label">INSTAGRAM URL</div>
                        <input type="url" name="redes_sociais[instagram]" class="field-input"
                            value="{{ old('redes_sociais.instagram', $redes['instagram'] ?? '') }}"
                            placeholder="#">
                    </div>
                    <div class="field-group">
                        <div class="setor-field-label">YOUTUBE URL</div>
                        <input type="url" name="redes_sociais[youtube]" class="field-input"
                            value="{{ old('redes_sociais.youtube', $redes['youtube'] ?? '') }}"
                            placeholder="#">
                    </div>
                </div>
            </div>
        </div>

        {{-- =============================== ABA 2: FALE CONOSCO =============================== --}}
        <div id="tab-fale" class="tab-panel">
            <div class="section-card">
                <div class="section-title">Fale Conosco (Setores)</div>
                <p class="text-sm text-slate-400 -mt-4 mb-6">Adicione linhas de atendimento por setor (ex: Central, Diretoria, Jurídico...)</p>

                <div id="setoresContainer" class="space-y-3">
                    @php $setores = $footer->fale_conosco ?? []; @endphp
                    @forelse($setores as $i => $setor)
                    <div class="setor-row flex items-center gap-3">
                        <div class="flex-1 space-y-2">
                            <div class="setor-field-label">{{ strtoupper($setor['setor'] ?? 'SETOR') }}</div>
                            <div class="flex gap-3">
                                <input type="text" name="fale_conosco[{{ $i }}][setor]" class="field-input"
                                    placeholder="Ex: Central SINDAUT-RIO"
                                    value="{{ old('fale_conosco.'.$i.'.setor', $setor['setor'] ?? '') }}">
                                <input type="text" name="fale_conosco[{{ $i }}][telefone]" class="field-input"
                                    placeholder="Ex: 3195-5142"
                                    value="{{ old('fale_conosco.'.$i.'.telefone', $setor['telefone'] ?? '') }}">
                            </div>
                        </div>
                        <button type="button" class="remove-setor-btn mt-6" onclick="removeSetor(this)" title="Remover">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                    @empty
                    <p class="text-sm text-slate-400 italic" id="emptySetoresMsg">Nenhum setor cadastrado. Clique em "Adicionar Setor" para começar.</p>
                    @endforelse
                </div>

                <button type="button" class="add-setor-btn mt-5" onclick="addSetor()">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Adicionar Setor
                </button>
            </div>
        </div>

        {{-- =============================== ABA 3: SEDE =============================== --}}
        <div id="tab-sede" class="tab-panel">
            <div class="section-card">
                <div class="section-title">Atendimento (Sede)</div>

                <div class="field-group">
                    <div class="icon-label">
                        <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                        TELEFONES DE ATENDIMENTO
                    </div>
                    <input type="text" name="sede_telefone" class="field-input"
                        value="{{ old('sede_telefone', $footer->sede_telefone) }}"
                        placeholder="(21) 3861-7050 / 3861-7051">
                </div>

                <div class="field-group">
                    <div class="icon-label">
                        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                        E-MAIL DE CONTATO
                    </div>
                    <input type="email" name="sede_email" class="field-input"
                        value="{{ old('sede_email', $footer->sede_email) }}"
                        placeholder="contato@sindaut.org.br">
                </div>

                <div class="field-group">
                    <div class="icon-label">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        ENDEREÇO DA SEDE
                    </div>
                    <textarea name="sede_endereco" class="field-input field-textarea"
                        placeholder="Rua Andre Cavalcante, 128&#10;Centro, Rio de Janeiro">{{ old('sede_endereco', $footer->sede_endereco) }}</textarea>
                </div>
            </div>
        </div>

        {{-- =============================== ABA 4: SUBSEDE =============================== --}}
        <div id="tab-subsede" class="tab-panel">
            <div class="section-card">
                <div class="section-title">Atendimento (Subsede)</div>

                <div class="field-group">
                    <div class="icon-label">
                        <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                        TELEFONE DA SUBSEDE
                    </div>
                    <input type="text" name="subsede_telefone" class="field-input"
                        value="{{ old('subsede_telefone', $footer->subsede_telefone) }}"
                        placeholder="(21) 2413-4071">
                </div>

                <div class="field-group">
                    <div class="icon-label">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        ENDEREÇO DA SUBSEDE
                    </div>
                    <textarea name="subsede_endereco" class="field-input field-textarea"
                        placeholder="Rua Barcelos Domingos, 76&#10;Sala 302 - Campo Grande">{{ old('subsede_endereco', $footer->subsede_endereco) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Copyright (fora das abas, sempre visível) --}}
        <div class="section-card mt-6">
            <div class="setor-field-label">COPYRIGHT</div>
            <input type="text" name="copyright" class="field-input"
                value="{{ old('copyright', $footer->copyright ?? 'SINDAUT-RIO') }}"
                placeholder="SINDAUT-RIO">
            <p class="text-xs text-slate-400 mt-2">Exibição: © {{ date('Y') }} SINDAUT-RIO. TODOS OS DIREITOS RESERVADOS.</p>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    // ---- TABS ----
    function switchTab(name) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + name).classList.add('active');
        event.currentTarget.classList.add('active');
        lucide.createIcons();
    }

    // ---- LOGO UPLOAD ----
    const logoInput = document.getElementById('logoInput');
    const logoDropzone = document.getElementById('logoDropzone');

    logoInput && logoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showLogoPreview(e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    logoDropzone && logoDropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    logoDropzone && logoDropzone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    logoDropzone && logoDropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            logoInput.files = dt.files;
            const reader = new FileReader();
            reader.onload = ev => showLogoPreview(ev.target.result);
            reader.readAsDataURL(file);
        }
    });

    function showLogoPreview(src) {
        const previewArea = document.getElementById('logoPreviewArea');
        const previewImg = document.getElementById('logoPreviewImg');
        const previewBox = document.getElementById('logoPreviewBox');
        if (previewArea) previewArea.style.display = 'block';
        if (previewImg) previewImg.src = src;
        if (previewBox) previewBox.style.display = 'flex';
    }

    // ---- SETORES ----
    let setorCount = {{ count($footer->fale_conosco ?? []) }};

    function addSetor() {
        const emptyMsg = document.getElementById('emptySetoresMsg');
        if (emptyMsg) emptyMsg.remove();

        const container = document.getElementById('setoresContainer');
        const idx = setorCount++;
        const row = document.createElement('div');
        row.className = 'setor-row flex items-center gap-3';
        row.innerHTML = `
            <div class="flex-1 space-y-2">
                <div class="setor-field-label">NOVO SETOR</div>
                <div class="flex gap-3">
                    <input type="text" name="fale_conosco[${idx}][setor]" class="field-input"
                        placeholder="Ex: Central SINDAUT-RIO">
                    <input type="text" name="fale_conosco[${idx}][telefone]" class="field-input"
                        placeholder="Ex: 3195-5142">
                </div>
            </div>
            <button type="button" class="remove-setor-btn mt-6" onclick="removeSetor(this)" title="Remover">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
            </button>
        `;
        container.appendChild(row);
    }

    function removeSetor(btn) {
        btn.closest('.setor-row').remove();
    }

    // ---- FORM SUBMIT LOADER ----
    const footerForm = document.getElementById('footerForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');

    if (footerForm) {
        footerForm.addEventListener('submit', function() {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
            btnText.textContent = 'SALVANDO...';
            btnLoader.classList.remove('hidden');
        });
    }
</script>
@endpush

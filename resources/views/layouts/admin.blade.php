<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | SINDAUT-RIO</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/img/favicon.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tiny.cloud/1/op59c4spowh6qvoqd3swhyqb20pm5ixuql7rq6ir09186kp0/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @media (min-width: 1024px) {
            #admin-sidebar:not(:hover) #menu-noticias-dropdown {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-50 flex h-screen overflow-hidden">

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden"
        onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar"
        class="group w-72 lg:w-20 lg:hover:w-72 bg-slate-900 text-white flex flex-col shadow-2xl fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static lg:flex-shrink-0 transition-all duration-300 ease-in-out">
        <div class="p-8 lg:p-5 lg:group-hover:p-8 flex items-center justify-between gap-3 transition-all duration-300">
            <div class="flex items-center gap-3 lg:gap-0 lg:group-hover:gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <span class="font-black tracking-tighter text-xl transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">ADMIN<span class="text-blue-500">PRO</span></span>
            </div>
            <!-- Close Button for Mobile -->
            <button type="button" onclick="toggleSidebar()"
                class="p-2 -mr-2 text-slate-400 hover:text-white lg:hidden focus:outline-none" aria-label="Fechar Menu">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <nav class="flex-1 px-4 py-2 space-y-2 overflow-y-auto no-scrollbar lg:px-3 lg:group-hover:px-4 transition-all duration-300">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Dashboard</span>
            </a>

            <!-- Benefícios -->
            <a href="{{ route('beneficio.index') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('beneficio.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="gift" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Benefícios</span>
            </a>

            <!-- Convenção Coletiva -->
            <a href="{{ route('convencao.index') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('convencao.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="file-signature" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Convenção Coletiva</span>
            </a>

            <!-- Departamento Jurídico -->
            <a href="{{ route('depjuridico.index') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('depjuridico.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="gavel" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Dep. Jurídico</span>
            </a>

            <!-- História -->
            <a href="{{ route('historia.index') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('historia.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="book-open" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">História</span>
            </a>

            <!-- Homologação -->
            <a href="{{ route('homologacao.index') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('homologacao.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Homologação</span>
            </a>

            <!-- Menu Notícias Dropdown -->
            @php
                $isNoticiasActive = request()->routeIs('noticia.*') || request()->routeIs('upload.*');
            @endphp
            <div class="flex flex-col">
                <button type="button"
                    onclick="document.getElementById('menu-noticias-dropdown').classList.toggle('hidden'); document.getElementById('menu-noticias-icon').classList.toggle('rotate-180');"
                    class="flex items-center justify-between px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ $isNoticiasActive ? 'bg-slate-800 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4">
                        <i data-lucide="newspaper" class="w-5 h-5 flex-shrink-0"></i>
                        <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Notícias & Mídia</span>
                    </div>
                    <i data-lucide="chevron-down" id="menu-noticias-icon"
                        class="w-4 h-4 transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto {{ $isNoticiasActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div id="menu-noticias-dropdown"
                    class="flex flex-col gap-1 mt-2 pl-4 {{ $isNoticiasActive ? '' : 'hidden' }}">
                    <a href="{{ route('noticia.index') }}"
                        class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-3 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('noticia.index') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="list" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Notícias</span>
                    </a>
                    <a href="{{ route('upload.index') }}"
                        class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-3 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('upload.index') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="image" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Galeria</span>
                    </a>
                </div>
            </div>


            <!-- Usuários -->
            <a href="{{ route('usuario.index') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('usuario.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Usuários</span>
            </a>

            <!-- Rodapé -->
            <a href="{{ route('footer-config.edit') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 px-6 py-4 lg:px-4 lg:group-hover:px-6 rounded-2xl transition-all duration-300 {{ request()->routeIs('footer-config.*') ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="panel-bottom" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Rodapé</span>
            </a>
        </nav>

        <div class="p-8 lg:p-4 lg:group-hover:p-8 border-t border-slate-800 space-y-4 transition-all duration-300">
            <a href="{{ route('site.home') }}" target="_blank" class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 text-slate-400 hover:text-white transition-all duration-300">
                <i data-lucide="external-link" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Ver Site</span>
            </a>
            <a href="{{ route('admin.logout') }}"
                class="flex items-center gap-4 lg:gap-0 lg:group-hover:gap-4 text-slate-400 hover:text-red-400 transition-all duration-300 w-full">
                <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                <span class="transition-all duration-300 lg:opacity-0 lg:group-hover:opacity-100 lg:w-0 lg:group-hover:w-auto whitespace-nowrap overflow-hidden">Sair</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-slate-50">
        <header
            class="bg-white border-b border-slate-200 px-6 lg:px-12 py-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button for Mobile -->
                <button type="button" onclick="toggleSidebar()"
                    class="p-2 -ml-2 text-slate-600 hover:text-slate-900 lg:hidden focus:outline-none"
                    aria-label="Abrir Menu">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div>
                    <h1 class="text-xl lg:text-2xl font-black text-slate-900 leading-tight">@yield('header_title')</h1>
                    <p
                        class="text-[9px] lg:text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mt-0.5">
                        @yield('header_subtitle')</p>
                </div>
            </div>

            <div class="flex items-center gap-4 lg:gap-6">
                @yield('header_actions')
                <div class="flex items-center gap-3 lg:gap-4 pl-3 lg:pl-6 border-l border-slate-100">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-slate-900 leading-tight">{{ auth()->user()->name ?? 'Administrador' }}</p>
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest leading-none mt-0.5">SINDAUT</p>
                    </div>
                    <div
                        class="w-10 h-10 lg:w-12 lg:h-12 bg-slate-100 rounded-full border-2 border-white shadow-md flex items-center justify-center text-slate-400 font-black flex-shrink-0">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-12 max-w-7xl mx-auto">
            @if(session('success'))
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-600 p-6 rounded-2xl mb-8 font-bold flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('danger'))
                <div
                    class="bg-rose-50 border border-rose-200 text-rose-600 p-6 rounded-2xl mb-8 font-bold flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    {{ session('danger') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

        // Initialize TinyMCE Editor
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: 'textarea.tinymce_editor',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough table emoticons| fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                language: 'pt_BR',
                height: 450,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_class: 'mceNonEditable',
                toolbar_mode: 'sliding',
                contextmenu: 'link image table',
                skin: 'oxide',
                content_css: 'default',
                content_style: 'body { font-family: Outfit, sans-serif; font-size: 16px }',
                file_picker_callback: function (callback, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    
                    if (meta.filetype === 'image') {
                        input.setAttribute('accept', 'image/*');
                    } else if (meta.filetype === 'file') {
                        input.setAttribute('accept', '.pdf,.doc,.docx,.xls,.xlsx,.txt');
                    }

                    input.onchange = function () {
                        var file = this.files[0];
                        
                        var formData = new FormData();
                        formData.append('file', file);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        fetch('/admin/tinymce/upload', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.location) {
                                callback(result.location, { text: file.name, title: file.name });
                            } else {
                                alert('Erro no upload: ' + (result.error || 'Erro desconhecido'));
                            }
                        })
                        .catch(error => {
                            console.error('Error during upload:', error);
                            alert('Falha ao enviar o arquivo.');
                        });
                    };

                    input.click();
                }
            });
        }

        // Toggle Sidebar for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Global Delete Confirmation
        function confirmDelete(formId, message = 'Tem certeza que deseja excluir este item?') {
            Swal.fire({
                title: 'Atenção!',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                borderRadius: '1.5rem',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase tracking-widest',
                    cancelButton: 'rounded-xl px-6 py-3 font-black text-xs uppercase tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Global Loading State for Forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (e) {
                if (this.method.toUpperCase() === 'POST' && this.querySelector('input[name="_method"][value="DELETE"]')) {
                    return;
                }

                const submitBtn = this.querySelector('button[type="submit"]') || document.querySelector(`button[form="${this.id}"]`);

                if (submitBtn) {
                    const originalContent = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-80', 'cursor-not-allowed', 'flex', 'items-center', 'justify-center', 'gap-3');
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="tracking-widest">PROCESSANDO...</span>
                    `;
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>

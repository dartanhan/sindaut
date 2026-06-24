<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | SINDAUT - Sindicato dos Empregados em Empresas de Asseio e Conservação</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @if(env('DATA_SITE_KEY'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</head>

<body class="bg-slate-950 font-['Outfit'] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-blue-900/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-white/5 backdrop-blur-3xl border border-white/10 p-12 rounded-[3rem] shadow-2xl space-y-10">
            <div class="text-center space-y-4">
                <div
                    class="w-20 h-20 bg-blue-600 rounded-[2rem] flex items-center justify-center mx-auto shadow-2xl shadow-blue-600/30">
                    <i data-lucide="lock" class="w-10 h-10 text-white"></i>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase">Painel <span
                        class="text-blue-500">Admin</span></h1>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Acesse para gerenciar o portal SINDAUT</p>
            </div>

            <form action="{{ route('admin.login.do') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-4">E-mail</label>
                    <input type="email" name="email" required placeholder="e-mail" value="{{ old('email') }}"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white font-bold placeholder:text-slate-700 focus:border-blue-600 focus:ring-0 transition">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-4">Senha</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white font-bold placeholder:text-slate-700 focus:border-blue-600 focus:ring-0 transition">
                </div>

                @if(env('DATA_SITE_KEY'))
                    <div class="flex justify-center py-2">
                        <div class="g-recaptcha" data-sitekey="{{ env('DATA_SITE_KEY') }}" data-theme="dark"></div>
                    </div>
                @endif

                @if($errors->any())
                    <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest text-center">
                        {{ $errors->first() }}</p>
                @endif
                @if(session('danger'))
                    <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest text-center">
                        {{ session('danger') }}</p>
                @endif

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-white hover:text-blue-600 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-blue-600/20 text-xs uppercase tracking-widest">
                    Entrar no Sistema
                </button>
            </form>
        </div>

        <p class="text-center mt-12 text-slate-600 text-[10px] font-black uppercase tracking-[0.2em]">
            &copy; 2026 SINDAUT | Tecnologia de Ponta
        </p>
    </div>

    <script>
        lucide.createIcons();

        document.querySelector('form').addEventListener('submit', function (e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed', 'flex', 'items-center', 'justify-center', 'gap-3');
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>ENTRANDO...</span>
            `;
        });
    </script>
</body>

</html>

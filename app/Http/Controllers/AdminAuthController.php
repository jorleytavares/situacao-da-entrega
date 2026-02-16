<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use App\Models\AdminLog;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        if (session('admin_autenticado')) {
            return redirect()->route('admin.visao_geral');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        // Rate limiting: 5 tentativas por minuto
        $key = 'admin-login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('erro', "Muitas tentativas. Aguarde {$seconds} segundos.");
        }

        RateLimiter::hit($key, 60);

        // Credenciais do .env
        $adminEmail = config('app.admin_email', 'admin@situacaodaentrega.com.br');
        $adminSenha = config('app.admin_senha', 'admin123');

        // Verifica senha (suporta hash bcrypt ou texto plano para compatibilidade)
        $senhaValida = false;
        if (str_starts_with($adminSenha, '$2y$')) {
            // Senha hasheada
            $senhaValida = Hash::check($request->senha, $adminSenha);
        } else {
            // Senha texto plano (qualquer ambiente se não for hash)
            $senhaValida = $request->senha === $adminSenha;
        }

        if ($request->email === $adminEmail && $senhaValida) {
            RateLimiter::clear($key);

            session(['admin_autenticado' => true]);
            session(['admin_email' => $request->email]);

            // Log de acesso
            $this->registrarLog('login', $request);

            return redirect()->route('admin.visao_geral')->with('sucesso', 'Login realizado!');
        }

        // Log de tentativa falha
        $this->registrarLog('login_falha', $request);

        return back()->with('erro', 'Credenciais inválidas.');
    }

    public function logout(Request $request)
    {
        $this->registrarLog('logout', $request);

        session()->forget(['admin_autenticado', 'admin_email']);

        return redirect()->route('admin.login')->with('sucesso', 'Logout realizado.');
    }

    private function registrarLog(string $acao, Request $request): void
    {
        try {
            AdminLog::create([
                'acao' => $acao,
                'email' => $request->input('email', session('admin_email')),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } catch (\Exception $e) {
            Log::warning('Falha ao registrar log admin: ' . $e->getMessage());
        }
    }
}

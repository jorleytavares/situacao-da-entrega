<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $slug)
    {
        // Validações
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensagem' => 'required|string',
        ]);

        // Carregar Post
        $post = Post::where('slug', $slug)->firstOrFail();

        // Criar Comentário
        Comentario::create([
            'post_id' => $post->id,
            'nome' => $request->nome,
            'email' => $request->email,
            'mensagem' => $request->mensagem,
            'status' => 'pendente', // Padrão
        ]);

        return response()->json(['success' => true], 200);
    }
}

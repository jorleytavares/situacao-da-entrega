<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class AdminComentarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Comentario::with('post')->orderByRaw("FIELD(status, 'pendente', 'aprovado', 'rejeitado')");

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $comentarios = $query->latest()->paginate(20);

        return view('admin.comentarios.index', compact('comentarios'));
    }

    public function update(Request $request, $id)
    {
        $comentario = Comentario::findOrFail($id);

        $request->validate([
            'status' => 'required|in:aprovado,rejeitado,pendente'
        ]);

        $comentario->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status do comentário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->back()->with('success', 'Comentário excluído com sucesso!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Artigo;

class ArtigoController extends Controller
{
    public function create(Request $request) {
        $array = ['error' => ''];

        $rules = [
            'titulo' => 'required',
            'conteudo' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $titulo = $request->input('titulo');
        $conteudo = $request->input('conteudo');

        $newArtigo = new Artigo();
        $newArtigo->titulo = $titulo;
        $newArtigo->conteudo = $conteudo;
        $newArtigo->save();

        return $array;
    }

    public function readAll() {
        $array = ['error' => ''];

        $artigo = Artigo::simplePaginate(5);

        $array['list'] = $artigo->items();

        return $array;
    }

    public function read($id) {
        $array = ['error' => ''];

        $artigo = Artigo::find($id);

        if($artigo) {
            $array['artigo'] = $artigo;
        } else {
            $array['error'] = 'O artigo '.$id.' não foi encontrado';
        }

        return $array;
    }

    public function update(Request $request, $id) {
        $array = ['error' => ''];

        $rules = [
            'titulo' => 'required',
            'conteudo' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $titulo = $request->input('titulo');
        $conteudo = $request->input('conteudo');

        $artigo = Artigo::find($id);

        if ($artigo) {
            if($titulo) {
                $artigo->titulo = $titulo;
            }
            if($conteudo) {
                $artigo->conteudo = $conteudo;
            }

            $artigo->save();
        } else {
            $array['error'] = 'O artigo '.$id.' não foi encontrado';
        }
    }

    public function delete($id) {
        $array = ['error' => ''];

        $artigo = Artigo::find($id);

        if($artigo) {
            $artigo->delete();
        } else {
            $array['error'] = 'O artigo '.$id.' não foi encontrado';
        }

        return $array;
    }

}

<?php

namespace Agenciafmd\Postal\Http\Controllers;

use Agenciafmd\Postal\Http\Requests\PostalRequest;
use Agenciafmd\Postal\Notifications\SendNotification;
use Agenciafmd\Postal\Postal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class PostalController extends Controller
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $query = QueryBuilder::for(Postal::class)
            ->defaultSort('-is_active', 'name')
            ->allowedSorts($request->sort)
            ->allowedFilters((($request->filter) ? array_keys($request->get('filter')) : []));

        if ($request->is('*/trash')) {
            $query->onlyTrashed();
        }

        $view['items'] = $query->paginate($request->get('per_page', 50));

        return view('agenciafmd/postal::index', $view);
    }

    public function create(Postal $postal)
    {
        $view['model'] = $postal;

        return view('agenciafmd/postal::form', $view);
    }

    public function store(PostalRequest $request)
    {
        if (Postal::create($request->all())) {
            flash('Item inserido com sucesso.', 'success');
        } else {
            flash('Falha no cadastro.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }

    public function show(Postal $postal)
    {
        $view['model'] = $postal;

        return view('agenciafmd/postal::form', $view);
    }

    public function edit(Postal $postal)
    {
        $view['model'] = $postal;

        return view('agenciafmd/postal::form', $view);
    }

    public function update(Postal $postal, PostalRequest $request)
    {
        if ($postal->update($request->all())) {
            flash('Item atualizado com sucesso.', 'success');
        } else {
            flash('Falha na atualização.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }

    public function destroy(Postal $postal)
    {
        if ($postal->delete()) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }

    public function restore($id)
    {
        $postal = Postal::onlyTrashed()
            ->find($id);

        if (!$postal) {
            flash('Item já restaurado.', 'danger');
        } elseif ($postal->restore()) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }

    public function batchDestroy(Request $request)
    {
        if (Postal::destroy($request->get('id', []))) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }

    public function batchRestore(Request $request)
    {
        $postal = Postal::onlyTrashed()
            ->whereIn('id', $request->get('id', []))
            ->restore();

        if ($postal) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }

    public function send(Postal $postal)
    {
        $postal->notify(new SendNotification([
            'greeting' => 'Olá ' . $postal->to_name . '!',
            'introLines' => [
                'Este é o e-mail de teste enviado pelo site.',
                '**Formulário:** ' . $postal->name,
                '**Assunto:** ' . $postal->subject,
                '**Para:** ' . $postal->to_name . ' (' . $postal->to . ')',
                '**Cópia:** ' . (($postal->cc) ?? 'Nenhuma'),
                '**Cópia Oculta:** ' . (($postal->bcc) ?? 'Nenhuma'),
            ],
            'actionText' => 'Visitar site',
            'actionUrl' => config('app.url'),
            'outroLines' => [
                'Estas são as linhas abaixo do botão.',
            ],
        ]));

        flash('Teste enviado com sucesso.', 'success');

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.postal.index');
    }
}

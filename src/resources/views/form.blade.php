@extends('agenciafmd/admix::partials.crud.form')

@section('form')
    @formModel(['model' => optional($model), 'create' => route('admix.postal.store'), 'update' => route('admix.postal.update', ['postal' => ($model->id) ?? 0]), 'id' => 'formCrud', 'class' => 'mb-0 card-list-group card' . ((count($errors) > 0) ? ' was-validated' : '')])
    <div class="card-header bg-gray-lightest">
        <h3 class="card-title">
            @if(request()->is('*/create'))
                Criar
            @elseif(request()->is('*/edit'))
                Editar
            @else
                Visualizar
            @endif
            Formulários
        </h3>
        <div class="card-options">
            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    <ul class="list-group list-group-flush">
        @if (optional($model)->id)
            @formText(['Código', 'id', null, ['disabled' => true]])

            @formText(['Identificação', 'slug', null, ['disabled' => true]])
        @endif

            @formIsActive(['Ativo', 'is_active', null, ['required']])

            @formText(['Nome', 'name', null, ['required']])

            @formText(['Para (nome)', 'to_name', null, ['required']])

            @formEmail(['Para (email)', 'to', null, ['required']])

            @formText(['Assunto', 'subject', null, ['required']])

            @formText(['Cópia (CC)', 'cc', null, [], 'Para mais de 1 e-mail, separe-os por vírgula'])

            @formText(['Cópia oculta (CCO)', 'bcc', null, [], 'Para mais de 1 e-mail, separe-os por vírgula'])
    </ul>
    <div class="card-footer bg-gray-lightest text-right">
        <div class="d-flex">
            @include('agenciafmd/admix::partials.btn.back')

            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    @formClose()
@endsection

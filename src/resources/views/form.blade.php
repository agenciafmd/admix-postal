@extends('agenciafmd/admix::partials.crud.form')

@section('title')
    @if(request()->is('*/create'))
        Criar
    @elseif(request()->is('*/edit'))
        Editar
    @else
        Visualizar
    @endif
    Formulário
@endsection

@section('form')
    {!! Form::bsOpen(['model' => optional($model), 'create' => route('admix.postal.store'), 'update' => route('admix.postal.update', ['postal' => ($model->id) ?? 0])]) !!}
    <div class="card-header bg-gray-lightest">
        <h3 class="card-title">Geral</h3>
    </div>
    <ul class="list-group list-group-flush">
        {!! Form::bsIsActive('Ativo', 'is_active', null, ['required']) !!}

        {!! Form::bsText('Nome', 'name', null, ['required']) !!}

        {!! Form::bsText('Para (nome)', 'to_name', null, ['required']) !!}

        {!! Form::bsEmail('Para (email)', 'to', null, ['required']) !!}

        {!! Form::bsText('Assunto', 'subject', null, ['required']) !!}

        {!! Form::bsText('Cópia (Cc)', 'cc', null, [], 'Para mais de 1 e-mail, separe-os por vírgula') !!}

        {!! Form::bsText('Cópia oculta (Cco)', 'bcc', null, [], 'Para mais de 1 e-mail, separe-os por vírgula') !!}
    </ul>
    <div class="card-footer bg-gray-lightest text-right">
        <div class="d-flex">
            @include('agenciafmd/admix::partials.btn.back')

            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection
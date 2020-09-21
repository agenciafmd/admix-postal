@extends('agenciafmd/admix::partials.crud.form')

@section('form')
    <x-admix::cards.form title="Formulário"
                         :create="route('admix.postal.store')"
                         :update="route('admix.postal.update', ['postal' => ($model->id) ?? 0])">
        <x-admix::forms.list-group>
            <x-admix::forms.group label="ativo" for="is_active">
                <x-admix::forms.boolean name="is_active" required="required" :selected="$model->is_active ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="nome" for="name">
                <x-admix::forms.input name="name" required="required" :value="$model->name ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="para (nome)" for="to_name">
                <x-admix::forms.input name="to_name" required="required" :value="$model->to_name ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="para (email)" for="to">
                <x-admix::forms.email name="to" required="required" :value="$model->to ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="assunto" for="subject">
                <x-admix::forms.input name="subject" required="required" :value="$model->subject ?? ''"/>
            </x-admix::forms.group>

            <x-admix::forms.group label="cópia (cc)" for="cc">
                <x-admix::forms.input name="cc" :value="$model->cc ?? ''"/>
                <x-slot name="help">
                    Para mais de 1 e-mail, separe-os por vírgula
                </x-slot>
            </x-admix::forms.group>

            <x-admix::forms.group label="cópia oculta (cco)" for="cco">
                <x-admix::forms.input name="cco" :value="$model->cco ?? ''"/>
                <x-slot name="help">
                    Para mais de 1 e-mail, separe-os por vírgula
                </x-slot>
            </x-admix::forms.group>
        </x-admix::forms.list-group>
    </x-admix::cards.form>
@endsection
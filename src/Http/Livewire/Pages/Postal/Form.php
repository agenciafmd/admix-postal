<?php

namespace Agenciafmd\Postal\Http\Livewire\Pages\Postal;

use Agenciafmd\Postal\Models\Postal;
use Agenciafmd\Support\Rules\CommaSeparatedEmails;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;

class Form extends Component
{
    use AuthorizesRequests;

    public Postal $model;

    public function mount(Postal $postal): void
    {
        ($postal->id) ? $this->authorize('update', Postal::class) : $this->authorize('create', Postal::class);

        $this->model = $postal;
        $this->model->is_active ??= false;
    }

    public function rules(): array
    {
        return [
            'model.is_active' => [
                'boolean',
            ],
            'model.name' => [
                'required',
                'max:255',
            ],
            'model.subject' => [
                'required',
                'max:255',
            ],
            'model.to_name' => [
                'required',
                'max:255',
            ],
            'model.to' => [
                'required',
                'email:rfc,dns',
            ],
            'model.cc' => [
                'nullable',
                new CommaSeparatedEmails(),
                'max:255',
            ],
            'model.bcc' => [
                'nullable',
                new CommaSeparatedEmails(),
                'max:255',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'is_active' => __('admix-postal::fields.is_active'),
            'name' => __('admix-postal::fields.name'),
            'subject' => __('admix-postal::fields.subject'),
            'to_name' => __('admix-postal::fields.to_name'),
            'to' => __('admix-postal::fields.to'),
            'cc' => __('admix-postal::fields.cc'),
            'bcc' => __('admix-postal::fields.bcc'),
        ];
    }

    public function submit(): null|RedirectResponse|Redirector
    {
        $this->validate($this->rules(), [], $this->attributes());

        try {
            if ($this->model->save()) {
                flash(__('crud.success.save'), 'success');
            } else {
                flash(__('crud.error.save'), 'error');
            }

            return redirect()->to(session()->get('backUrl') ?: route('admix.postal.index'));
        } catch (\Exception $e) {
            $this->emit('toast', [
                'level' => 'danger',
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field, $this->rules(), [], $this->attributes());
    }

    public function render(): View
    {
        return view('admix-postal::pages.postal.form')
            ->extends('admix::internal')
            ->section('internal-content');
    }
}

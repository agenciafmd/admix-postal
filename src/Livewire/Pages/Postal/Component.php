<?php

namespace Agenciafmd\Postal\Livewire\Pages\Postal;

use Agenciafmd\Postal\Models\Postal;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Livewire\Component as LivewireComponent;
use Livewire\Features\SupportRedirects\Redirector;

class Component extends LivewireComponent
{
    use AuthorizesRequests;

    public Form $form;

    public Postal $postal;

    public function mount(Postal $postal): void
    {
        ($postal->exists) ? $this->authorize('update', Postal::class) : $this->authorize('create', Postal::class);

        $this->postal = $postal;
        $this->form->setModel($postal);
    }

    public function submit(): null|Redirector|RedirectResponse
    {
        try {
            if ($this->form->save()) {
                flash(($this->postal->exists) ? __('crud.success.save') : __('crud.success.store'), 'success');
            } else {
                flash(__('crud.error.save'), 'error');
            }

            return redirect()->to(session()->get('backUrl') ?: route('admix.postal.index'));
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->dispatch(event: 'toast', level: 'danger', message: $exception->getMessage());
        }

        return null;
    }

    public function render(): View
    {
        return view('admix-postal::pages.postal.form')
            ->extends('admix::internal')
            ->section('internal-content');
    }
}

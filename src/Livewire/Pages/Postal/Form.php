<?php

namespace Agenciafmd\Postal\Livewire\Pages\Postal;

use Agenciafmd\Postal\Models\Postal;
use Agenciafmd\Support\Rules\CommaSeparatedEmails;
use Livewire\Attributes\Validate;
use Livewire\Form as LivewireForm;

class Form extends LivewireForm
{
    public Postal $postal;

    #[Validate]
    public bool $is_active = true;

    #[Validate]
    public string $name = '';

    #[Validate]
    public string $subject = '';

    #[Validate]
    public string $to_name = '';

    #[Validate]
    public string $to = '';

    #[Validate]
    public ?string $cc = '';

    #[Validate]
    public ?string $bcc = '';

    public function setModel(Postal $postal): void
    {
        $this->postal = $postal;
        if ($postal->exists) {
            $this->is_active = $postal->is_active;
            $this->name = $postal->name;
            $this->subject = $postal->subject;
            $this->to_name = $postal->to_name;
            $this->to = $postal->to;
            $this->cc = $postal->cc;
            $this->bcc = $postal->bcc;
        }
    }

    public function rules(): array
    {
        return [
            'is_active' => [
                'boolean',
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'subject' => [
                'required',
                'max:255',
            ],
            'to_name' => [
                'required',
                'max:255',
            ],
            'to' => [
                'required',
                'email:rfc,dns',
            ],
            'cc' => [
                'nullable',
                new CommaSeparatedEmails,
                'max:255',
            ],
            'bcc' => [
                'nullable',
                new CommaSeparatedEmails,
                'max:255',
            ],
        ];
    }

    public function prepareForValidation($attributes): array
    {
        $this->cc = $attributes['cc'] = $this->normalizeCopies($attributes['cc']);
        $this->bcc = $attributes['bcc'] = $this->normalizeCopies($attributes['bcc']);

        return $attributes;
    }

    public function validationAttributes(): array
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

    public function save(): bool
    {
        $this->validate(rules: $this->rules(), attributes: $this->validationAttributes());
        $this->postal->fill($this->except('postal'));

        return $this->postal->save();
    }

    private function normalizeCopies(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return str($value)
            ->squish()
            ->replace(' ', '')
            ->replace(';', ',')
            ->explode(',')
            ->map(fn ($value) => trim($value))
            ->implode(',');
    }
}

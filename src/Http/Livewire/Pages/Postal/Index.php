<?php

namespace Agenciafmd\Postal\Http\Livewire\Pages\Postal;

use Agenciafmd\Admix\Http\Livewire\Pages\Base\Index as BaseIndex;
use Agenciafmd\Components\LaravelLivewireTables\Columns\EmitColumn;
use Agenciafmd\Postal\Models\Postal;
use Agenciafmd\Postal\Notifications\SendNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class Index extends BaseIndex
{
    protected $model = Postal::class;
    protected string $indexRoute = 'admix.postal.index';
    protected string $trashRoute = 'admix.postal.trash';
    protected string $creteRoute = 'admix.postal.create';
    protected string $editRoute = 'admix.postal.edit';

    public function configure(): void
    {
        $this->packageName = __(config('admix-postal.name'));

        $this->setAdditionalListeners([
            'send' => 'send',
        ]);

        parent::configure();
    }

    public function filters(): array
    {
        $this->setAdditionalFilters([
            TextFilter::make(__('admix-postal::fields.to'), 'email')
                ->filter(function (Builder $builder, string $value) {
                    $builder->where("postal.to", 'LIKE', "%{$value}%");
                }),
        ]);

        return parent::filters();
    }

    public function columns(): array
    {
        $this->setAdditionalActionButtons([
            EmitColumn::make('')
                ->title(fn($row) => __('Send'))
                ->location(fn($row) => "window.livewire.emitTo('" . Str::of(self::class)
                        ->lower()
                        ->replace('\\', '.')
                        ->toString() . "', 'send', $row->id)")
                ->attributes(function ($row) {
                    return [
                        'class' => 'btn ms-0 ms-md-2',
                    ];
                }),
        ]);

        $this->setAdditionalColumns([
            Column::make(__('admix-postal::fields.to'), 'to')
                ->sortable()
                ->searchable(),
        ]);

        return parent::columns();
    }

    public function send(Postal $postal): void
    {
        try {
            $postal->notify(new SendNotification(
                [
                    'greeting' => __('Hi :name!', ['name' => $postal->to_name]),
                    'introLines' => [
                        __('This is the test email sent by the website.'),
                        "**" . ucfirst(__('admix-postal::fields.name')) . ":** {$postal->name}",
                        "**" . ucfirst(__('admix-postal::fields.subject')) . ":** {$postal->subject}",
                        "**" . ucfirst(__('admix-postal::fields.to_name')) . ":** {$postal->to_name} ({$postal->to})",
                        '**' . ucfirst(__('admix-postal::fields.cc')) . ':** ' . (($postal->cc) ?? 'Nenhuma'),
                        '**' . ucfirst(__('admix-postal::fields.bcc')) . ':** ' . (($postal->bcc) ?? 'Nenhuma'),
                    ],
                    'actionText' => __('Visit the website'),
                    'actionUrl' => config('app.url'),
                    'outroLines' => [
                        __('These are the lines below the button.'),
                    ],
                ],
            ));

            $this->emit('toast', [
                'level' => 'success',
                'message' => __('Test send successfully.'),
            ]);
        } catch (\Exception $e) {
            $this->emit('toast', [
                'level' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
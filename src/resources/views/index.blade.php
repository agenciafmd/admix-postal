@extends('agenciafmd/admix::partials.crud.index', [
    'route' => (request()->is('*/trash') ? route('admix.postal.trash') : route('admix.postal.index'))
])

@section('title')
    @if(request()->is('*/trash'))
        Lixeira de
    @endif
    Formulários
@endsection

@section('actions')
    @if(request()->is('*/trash'))
        @include('agenciafmd/admix::partials.btn.back', ['url' => route('admix.postal.index')])
    @else
        @can('create', \Agenciafmd\Postal\Models\Postal::class)
            @include('agenciafmd/admix::partials.btn.create', ['url' => route('admix.postal.create'), 'label' => 'Formulário'])
        @endcan
        @can('restore', \Agenciafmd\Postal\Models\Postal::class)
            @include('agenciafmd/admix::partials.btn.trash', ['url' => route('admix.postal.trash')])
        @endcan
    @endif
@endsection

@section('batch')
    @if(request()->is('*/trash'))
        @can('restore', \Agenciafmd\Postal\Models\Postal::class)
            <x-admix::batchs.select name="batch" selected=""
                                    :options="['' => 'com os selecionados', route('admix.postal.batchRestore') => '- restaurar']"/>
        @endcan
    @else
        @can('delete', \Agenciafmd\Postal\Models\Postal::class)
            <x-admix::batchs.select name="batch" selected=""
                                    :options="['' => 'com os selecionados', route('admix.postal.batchDestroy') => '- remover']"/>
        @endcan
    @endif
@endsection

@section('filters')
    <x-admix::filters.input label="email" name="to"/>
@endsection

@section('table')
    @if($items->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-borderless table-vcenter card-table text-nowrap">
                <thead>
                <tr>
                    <th class="w-1 d-none d-md-table-cell">&nbsp;</th>
                    <th class="w-1">{!! column_sort('#', 'id') !!}</th>
                    <th>{!! column_sort('Nome', 'name') !!}</th>
                    <th>{!! column_sort('Email', 'to') !!}</th>
                    <th>{!! column_sort('Status', 'is_active') !!}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <label class="mb-1 custom-control custom-checkbox">
                                <input type="checkbox" class="js-check custom-control-input"
                                       name="check[]" value="{{ $item->id }}">
                                <span class="custom-control-label">&nbsp;</span>
                            </label>
                        </td>
                        <td><span class="text-muted">{{ $item->id }}</span></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->to }}</td>
                        <td>
                            @livewire('admix::is-active', ['myModel' => get_class($item), 'myId' => $item->id])
                        </td>
                        @if(request()->is('*/trash'))
                            <td class="w-1 text-right">
                                @include('agenciafmd/admix::partials.btn.restore', ['url' => route('admix.postal.restore', $item->id)])
                            </td>
                        @else
                            <td class="w-1 text-center">
                                <div class="item-action dropdown">
                                    <a href="#" data-toggle="dropdown" class="icon">
                                        <i class="icon fe-more-vertical text-muted"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', \Agenciafmd\Postal\Models\Postal::class)
                                            @include('agenciafmd/admix::partials.btn.edit', ['url' => route('admix.postal.edit', $item->id)])
                                            @include('agenciafmd/postal::partials.btn.send', ['url' => route('admix.postal.send', $item->id)])
                                        @endcan
                                        @can('delete', \Agenciafmd\Postal\Models\Postal::class)
                                            @include('agenciafmd/admix::partials.btn.remove', ['url' => route('admix.postal.destroy', $item->id)])
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $items->appends(request()->except(['page']))->links() !!}
    @else
        @include('agenciafmd/admix::partials.info.not-found')
    @endif
@endsection

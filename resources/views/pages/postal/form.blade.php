<x-page.form
        headerTitle="{{ $model->id ? __('Update :name', ['name' => __(config('admix-postal.name'))]) : __('Create :name', ['name' => __(config('admix-postal.name'))]) }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.label for="model.is_active">
                {{ Str::of(__('admix-postal::fields.is_active'))->ucfirst() }}
            </x-form.label>
            <x-form.checkbox name="model.is_active"
                             class="form-switch form-switch-lg"
                             :label-on="__('Yes')"
                             :label-off="__('No')"
            />
        </div>
        <div class="col-md-6 mb-3">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.input name="model.name" :label="__('admix-postal::fields.name')" :disabled="(bool)($model->id)"/>
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="model.subject" :label="__('admix-postal::fields.subject')"/>
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="model.to_name" :label="__('admix-postal::fields.to_name')"/>
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="model.to" :label="__('admix-postal::fields.to')"/>
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="model.cc"
                          :label="__('admix-postal::fields.cc')"
                          :hint="__('For more than 1 e-mail, use comma to separate then')"
            />
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="model.bcc"
                          :label="__('admix-postal::fields.bcc')"
                          :hint="__('For more than 1 e-mail, use comma to separate then')"
            />
        </div>
    </div>

    <x-slot:cardComplement>
        @if($model->id)
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.id')"
                                  :value="$model->id"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.slug')"
                                  :value="$model->slug"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.created_at')"
                                  :value="$model->created_at->format(config('admix.timestamp.format'))"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.updated_at')"
                                  :value="$model->updated_at->format(config('admix.timestamp.format'))"/>
            </div>
        @endif
    </x-slot:cardComplement>
</x-page.form>

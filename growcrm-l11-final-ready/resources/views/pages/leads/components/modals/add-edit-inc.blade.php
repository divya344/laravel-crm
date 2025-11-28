<div class="row">
    <div class="col-lg-12">

        <!-- Meta Data - Created By -->
        @if(isset($page['section']) && $page['section'] == 'edit')
        <div class="modal-meta-data mb-3">
            <small>
                <strong>{{ cleanLang(__('lang.created_by')) }}:</strong>
                {{ $lead->first_name ?? runtimeUnkownUser() }} |
                {{ runtimeDate($lead->lead_created) }}
            </small>
        </div>
        @endif

        <!-- Lead Title -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label required">
                {{ cleanLang(__('lang.lead_title')) }}*
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="lead_title" name="lead_title"
                    value="{{ $lead->lead_title ?? '' }}">
            </div>
        </div>

        <!-- First Name -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label required">
                {{ cleanLang(__('lang.first_name')) }}*
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="lead_firstname" name="lead_firstname"
                    value="{{ $lead->lead_firstname ?? '' }}">
            </div>
        </div>

        <!-- Last Name -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label required">
                {{ cleanLang(__('lang.last_name')) }}*
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="lead_lastname" name="lead_lastname"
                    value="{{ $lead->lead_lastname ?? '' }}">
            </div>
        </div>

        <!-- Telephone -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label">
                {{ cleanLang(__('lang.telephone')) }}
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="lead_phone" name="lead_phone"
                    value="{{ $lead->lead_phone ?? '' }}">
            </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label">
                {{ cleanLang(__('lang.email_address')) }}
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="email" class="form-control form-control-sm" id="lead_email" name="lead_email"
                    value="{{ $lead->lead_email ?? '' }}">
            </div>
        </div>

        <!-- Lead Value -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label">
                {{ cleanLang(__('lang.lead_value')) }}
                ({{ config('system.settings_system_currency_symbol') }})
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="number" step="0.01" class="form-control form-control-sm" id="lead_value" name="lead_value"
                    value="{{ $lead->lead_value ?? '' }}">
            </div>
        </div>

        <!-- Assigned Users -->
        @if(config('visibility.lead_modal_assign_fields'))
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label">
                {{ cleanLang(__('lang.assigned')) }}
            </label>
            <div class="col-sm-12 col-lg-9">
                <select name="assigned[]" id="assigned"
                    class="form-control form-control-sm select2-basic select2-multiple" multiple>
                    @php $assigned = $lead->assigned->pluck('id')->toArray() ?? []; @endphp
                    @foreach(config('system.team_members') as $user)
                    <option value="{{ $user->id }}" {{ in_array($user->id, $assigned) ? 'selected' : '' }}>
                        {{ $user->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <!-- Status -->
        @if(request('status') != '' && array_key_exists(request('status'), config('system.lead_statuses')))
        <input type="hidden" name="lead_status" value="{{ request('status') }}">
        @else
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label required">
                {{ cleanLang(__('lang.status')) }}*
            </label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="lead_status" name="lead_status">
                    @foreach($statuses as $status)
                    <option value="{{ $status->leadstatus_id }}"
                        {{ ($lead->lead_status ?? '') == $status->leadstatus_id ? 'selected' : '' }}>
                        {{ runtimeLang($status->leadstatus_title) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <!-- Notes -->
        <div class="form-group row mt-4">
            <label class="col-sm-12 col-form-label">{{ cleanLang(__('lang.notes')) }}</label>
            <div class="col-sm-12">
                <textarea class="form-control form-control-sm tinymce-textarea" rows="5" name="lead_description"
                    id="lead_description">{{ $lead->lead_description ?? '' }}</textarea>
            </div>
        </div>

        <!-- Company Info -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label">
                {{ cleanLang(__('lang.company_name')) }}
            </label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="lead_company_name"
                    name="lead_company_name" value="{{ $lead->lead_company_name ?? '' }}">
            </div>
        </div>

        <!-- Website -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 col-form-label">{{ cleanLang(__('lang.website')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="lead_website" name="lead_website"
                    value="{{ $lead->lead_website ?? '' }}">
            </div>
        </div>

        <!-- Required Note -->
        <div class="row mt-3">
            <div class="col-12">
                <small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small>
            </div>
        </div>
    </div>
</div>

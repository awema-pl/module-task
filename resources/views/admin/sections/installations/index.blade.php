@extends('indigo-layout::installation')

@section('meta_title', _p('task::pages.admin.installation.meta_title', 'Installation module Status') . ' - ' . config('app.name'))
@section('meta_description', _p('task::pages.admin.installation.meta_description', 'Installation module Status in application'))

@push('head')

@endpush

@section('title')
    <h2>{{ _p('task::pages.admin.installation.headline', 'Installation module Status') }}</h2>
@endsection

@section('content')
    <form-builder disabled-dialog="" url="{{ route('task.admin.installation.index') }}" send-text="{{ _p('task::pages.admin.installation.send_text', 'Install') }}"
    edited>
        <div class="section">
            <div class="section">
                {{ _p('task::pages.admin.installation.will_be_execute_migrations', 'Will be execute package migrations') }}
            </div>
        </div>
    </form-builder>
@endsection

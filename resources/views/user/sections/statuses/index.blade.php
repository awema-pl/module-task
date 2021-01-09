@extends('indigo-layout::main')

@section('meta_title', _p('task::pages.user.status.meta_title', 'Statuses') . ' - ' . config('app.name'))
@section('meta_description', _p('task::pages.user.status.meta_description', 'Task statuses in the system.'))

@push('head')

@endpush

@section('title')
    {{ _p('task::pages.user.status.headline', 'Statuses') }}
@endsection

@section('create_button')
 @endsection

@section('content')
    <div class="grid">
        <div class="cell-1-1 cell--dsm">
            <h4>{{ _p('task::pages.user.status.statuses', 'Statuses') }}</h4>
            <div class="card">
                <div class="card-body">
                    <content-wrapper :url="$url.urlFromOnlyQuery('{{ route('task.user.status.scope')}}', ['page', 'limit'], $route.query)"
                        :check-empty="function(test) { return !(test && (test.data && test.data.length || test.length)) }"
                        name="statuses_table">
                        <template slot-scope="table">
                            <table-builder :default="table.data">
                                <tb-column name="type" label="{{ _p('task::pages.user.status.type', 'Type') }}">
                                    <template slot-scope="col">
                                        @{{ col.data.type_trans }}
                                        <div v-if="col.data.interrupt">
                                            <span class="badge badge_sky ml-4">{{ _p('task::pages.user.status.interrupted', 'Interrupted') }}</span>
                                        </div>
                                    </template>
                                   </tb-column>
                                <tb-column name="status" label="{{ _p('task::pages.user.status.status', 'Status') }}">
                                    <template slot-scope="col">
                                        @{{ col.data.status_trans }}
                                        <div class="cl-caption">@{{ status_detail_trans }}</div>
                                    </template>
                                </tb-column>
                                <tb-column name="error" label="{{ _p('task::pages.user.status.error', 'Error') }}">
                                    <template slot-scope="col">
                                        <div v-if="col.data.error">
                                            <span class="badge badge_warn mr-4">{{ _p('task::pages.user.status.error', 'Error') }}</span>
                                            <context-menu right boundary="table">
                                                <button type="submit" class="btn">
                                                    {{_p('task::pages.user.status.show_error', 'Show error')}}
                                                </button>
                                            </context-menu>
                                        </div>
                                    </template>
                                </tb-column>
                                <tb-column name="created_at" label="{{ _p('task::pages.user.status.created_at', 'Created at') }}"></tb-column>
                                <tb-column name="manage" label="{{ _p('task::pages.user.status.options', 'Options')  }}">
                                    <template slot-scope="col">
                                        <context-menu right boundary="table">
                                            <button type="submit" slot="toggler" class="btn">
                                                {{_p('task::pages.user.status.options', 'Options')}}
                                            </button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'interruptStatus', data: col.data}); AWEMA.emit('modal::interrupt_status:open')">
                                                {{_p('task::pages.user.status.interrupt', 'Interrupt')}}
                                            </cm-button>
                                        </context-menu>
                                    </template>
                                </tb-column>
                            </table-builder>

                            <paginate-builder v-if="table.data"
                                :meta="table.meta"
                            ></paginate-builder>
                        </template>
                        @include('indigo-layout::components.base.loading')
                        @include('indigo-layout::components.base.empty')
                        @include('indigo-layout::components.base.error')
                    </content-wrapper>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    <modal-window name="interrupt_status" class="modal_formbuilder" title="{{  _p('task::pages.user.status.are_you_sure_interrupt_status', 'Are you sure interrupt the status?') }}">
        <form-builder :edited="true" url="{{route('task.user.status.interrupt') }}/{id}" method="post"
                      @sended="AWEMA.emit('content::statuses_table:update')"
                      send-text="{{ _p('task::pages.user.status.confirm', 'Confirm') }}" store-data="interruptStatus"
                      disabled-dialog>

        </form-builder>
    </modal-window>
@endsection

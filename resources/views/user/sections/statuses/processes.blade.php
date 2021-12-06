<task-status class="mt-15" :types=@json($types) name="{{'task-sources-' . ($name ?? '0')}}" url="{{ route('task.user.status.widget')}}"></task-status>

@push('scripts')
    <div class="modals">
        <modal-window name="error_detail_status" class="modal_formbuilder" theme="fullscreen" title="{{ _p('task::pages.user.status.error_detail', 'Error detail') }}">
            <div v-if="AWEMA._store.state.errorDetailStatus && AWEMA._store.state.errorDetailStatus.error">
                <div style="overflow-x: scroll;">
                    @{{ AWEMA._store.state.errorDetailStatus.error }}
                </div>
            </div>
        </modal-window>
    </div>
@endpush

<template>
    <div>
        <content-wrapper store-data="taskStatuses">
            <template slot-scope="statuses">
                <div class="mb-10">
                    <div class="grid">
                        <div class="cell-1-1 cell--dsm">
                            <table-builder :default="statuses.data">
                                <tb-column name="name" :label="$lang.PROCESSES">
                                    <template slot-scope="col">
                                        <div>
                                            <span class="cl-caption">{{$lang.STATUS}}:</span>
                                            <span class="badge"
                                                  :class="{'badge_grass': col.data.status==='finished', 'badge_sky': col.data.status==='executing', 'badge_warn': col.data.status==='failed'}">
                                                {{col.data.status_trans}}
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <small>{{col.data.type_trans}}</small>
                                        </div>
                                    </template>

                                </tb-column>
                                <tb-column name="manage" label=" ">
                                    <template slot-scope="col">
                                        <context-menu right>
                                            <button type="submit" slot="toggler" class="btn">
                                                {{$lang.OPTIONS}}
                                            </button>
                                            <cm-button v-if="col.data.error" @click="AWEMA._store.commit('setData', {param: 'errorDetailStatus', data: col.data}); AWEMA.emit('modal::error_detail_status:open')">
                                                {{$lang.ERROR_DETAIL}}
                                            </cm-button>
                                        </context-menu>
                                    </template>
                                </tb-column>
                            </table-builder>
                        </div>
                    </div>
                </div>
            </template>
            <div slot="empty"></div>
        </content-wrapper>

        <!--    <button class="form-builder__send btn" @click="testDebug">Test console log for debug</button>-->
        <!--    <p>From config JS file: {{this.example_data}}</p>-->
        <!--    <p>Example function: {{this.exampleFromFunction}}</p>-->
        <!--    <p>-->
        <!--        <button class="form-builder__send btn" @click="testLoading">Test loading</button>-->
        <!--        <span v-if="isLoading">is loading...</span>-->
        <!--    </p>-->


    </div>
</template>

<script>
import taskMixin from '../js/mixins/task'
import {consoleDebug} from '../js/modules/helpers'
let _uniqSectionId = 0;
export default {
    name: 'status',
    mixins: [ taskMixin ],
    props: {
        name: {
            type: String,
            default() {
                return `status-${ _uniqSectionId++ }`
            }
        },
        default: Object,
        statusTypes: Object,
        refreshStatuses: {
            type: Boolean,
            default: true
        },
        refreshInterval: {
            type: Number,
            default: 2000
        },
        storeData: String,
        types: {
            type: Array,
            required: true,
        },
        url: {
            type: String,
            required: true,
        }
    },
    computed: {
        status() {
            return this.$store.state.task[this.name]
        },
        isLoading() {
            return this.status && this.status.isLoading
        },
    },
    created() {
      //  let data = this.storeData ? this.$store.state[this.storeData] : (this.default || {})
        this.$store.commit('task/create', {
            name: this.name,
        })
    },
    mounted() {
        this.loadStatuses()
        if (this.refreshStatuses){
            this.loopRefreshStatuses()
        }
    },
    methods: {
        loadStatuses(){
            this.$store.dispatch('task/loadStatuses', {
                name: this.name,
                types: this.types,
                url: this.url,
            })
        },
        loopRefreshStatuses(){
            setInterval(()=>{
                if (!this.isLoading){
                    this.loadStatuses()
                }
            }, this.refreshInterval)
        },

        // testDebug(){
        //     consoleDebug('message', ['data1'], ['data2'])
        // },

        // testLoading(){
        //     if ( this.isLoading) return;
        //
        //     AWEMA.emit(`task::${this.name}:before-test-loading`)
        //
        //     this.$store.dispatch('task/testLoading', {
        //         name: this.name
        //     }).then( data => {
        //         consoleDebug('data', data);
        //         this.$emit('success', data.data)
        //         this.$store.$set(this.name, this.$get(data, 'data', {}))
        //     })
        // }
    },


    beforeDestroy() {

    }
}
</script>

import {consoleDebug} from '../modules/helpers'

export const state = () => ({})

export const getters = {
    task: state => name => {
        return state[name]
    },
    isLoading: (state, getters) => name => {
        const task = getters.task(name)
        return task && task.isLoading
    },
    url: (state, getters) => name => {
        const task = getters.task(name)
        return task && task.url
    },
}

export const mutations = {
    create(state, {name, url, data}) {
        Vue.set(state, name, {
            isLoading: false,
            data,
        })
    },
    setLoading(state, {name, status}) {
        Vue.set(state[name], 'isLoading', status)
    },
}

export const actions = {
    loadStatuses({ state, commit, dispatch }, {name, types, url}) {
        return new Promise( resolve => {
            commit('setLoading', {name, status:true})
            AWEMA.ajax({types}, url, 'post')
                .then( data => {
                    if ( data.success ) {
                        AWEMA._store.commit('setData', {
                            param: 'taskStatuses',
                            data: data.data
                        });
                    }
                })
                .finally( () => {
                    commit('setLoading', { name, status: false })
                    resolve()
                })
        })
    },

    // restoreData({ state }, { name }) {
    //     const task = state[name]
    //     return task.exampleData || 'example-data';
    // },

    // testLoading({ state, commit, dispatch }, {name}) {
    //
    //     return new Promise( resolve => {
    //
    //         let _data
    //         const task = state[name]
    //
    //         commit('setLoading', {name, status:true})
    //
    //         dispatch('restoreData', { name })
    //             .then( data => {
    //                 consoleDebug('data', data);
    //                 return ['data-2']
    //             })
    //             .then( data => {
    //                 _data = data
    //                 consoleDebug('data-2', data);
    //             })
    //             .finally( () => {
    //                setTimeout(()=>{
    //                    commit('setLoading', { name, status: false })
    //                    resolve( _data )
    //                }, 2000)
    //             })
    //     })
    // }
}

export default {
    state,
    getters,
    mutations,
    actions,
    namespaced: true
}

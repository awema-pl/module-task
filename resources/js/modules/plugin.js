import taskStatus from '../../vue/task-status.vue'
// import { loadExternalLib } from '../utils/externalLib.js'

export function install(Vue) {

    if ( this.installed ) return
    this.installed = true

    Vue.component('task-status', taskStatus)

    // Vue.component('example-component', resolve => {
    //     AWEMA.utils.loadModule(
    //         'vue-example-plugin',
    //         'https://unpkg.com/vue-example-plugin@0.0.1/dist/vue-example-plugin.js',
    //         () => { resolve(importExampleComponent) }
    //     )
    // })
    // Vue.component('example-component-2', resolve => {
    //     loadExternalLib().then( () => { resolve(importExampleComponent2) })
    // })
}

export default {
    installed: false,
    install
}

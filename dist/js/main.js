(function () {
    'use strict';

    var name = "task";
    var version = "1.0.0";

    /**
     * Example const
     *
     * @const {String} EXAMPLE_CONST
     */


    /**
     * Restores flatted single-level object to a nested object
     *
     * @returns {Boolean}
     *
     */

    function exampleFunction() {
        return 'example-function';
    }

    function consoleDebug(message, ...optionalParams){
        if (AWEMA_CONFIG.dev === true){
            console.debug(message, optionalParams);
        }
    }

    var _config = {
        example_data: 'example-data-from-config'
    };

    var taskMixin = {

        props: {
            example_data: {
                type: String,
                default() {
                    return this._config.example_data
                }
            }
        },

        inject: {

        },

        computed: {

            exampleFromFunction() {
                return exampleFunction();
            },
        },

        beforeCreate() {
            this._config = Object.assign( _config, AWEMA.utils.object.get(AWEMA_CONFIG, 'task', {}) );
        }
    };

    //

    let _uniqSectionId = 0;

    var script = {

        name: 'task',

        mixins: [ taskMixin ],

        props: {
            name: {
                type: String,
                default() {
                    return `task-${ _uniqSectionId++ }`
                }
            },

            default: Object,

            storeData: String,
        },


        computed: {
            task() {
                return this.$store.state.task[this.name]
            },

            isLoading() {
                return this.task && this.task.isLoading
            },
        },

        created() {

            let data = this.storeData ? this.$store.state[this.storeData] : (this.default || {});

            this.$store.commit('task/create', {
                name: this.name,
                data
            });
        },

        mounted() {

        },

        methods: {
            testDebug(){
                consoleDebug('message', ['data1'], ['data2']);
            },

            testLoading(){
                if ( this.isLoading) return;

                AWEMA.emit(`task::${this.name}:before-test-loading`);

                this.$store.dispatch('task/testLoading', {
                    name: this.name
                }).then( data => {
                    consoleDebug('data', data);
                    this.$emit('success', data.data);
                    this.$store.$set(this.name, this.$get(data, 'data', {}));
                });
            }
        },


        beforeDestroy() {

        }
    };

    function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier
    /* server only */
    , shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
      if (typeof shadowMode !== 'boolean') {
        createInjectorSSR = createInjector;
        createInjector = shadowMode;
        shadowMode = false;
      } // Vue.extend constructor export interop.


      var options = typeof script === 'function' ? script.options : script; // render functions

      if (template && template.render) {
        options.render = template.render;
        options.staticRenderFns = template.staticRenderFns;
        options._compiled = true; // functional template

        if (isFunctionalTemplate) {
          options.functional = true;
        }
      } // scopedId


      if (scopeId) {
        options._scopeId = scopeId;
      }

      var hook;

      if (moduleIdentifier) {
        // server build
        hook = function hook(context) {
          // 2.3 injection
          context = context || // cached call
          this.$vnode && this.$vnode.ssrContext || // stateful
          this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext; // functional
          // 2.2 with runInNewContext: true

          if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
            context = __VUE_SSR_CONTEXT__;
          } // inject component styles


          if (style) {
            style.call(this, createInjectorSSR(context));
          } // register component module identifier for async chunk inference


          if (context && context._registeredComponents) {
            context._registeredComponents.add(moduleIdentifier);
          }
        }; // used by ssr in case component is cached and beforeCreate
        // never gets called


        options._ssrRegister = hook;
      } else if (style) {
        hook = shadowMode ? function () {
          style.call(this, createInjectorShadow(this.$root.$options.shadowRoot));
        } : function (context) {
          style.call(this, createInjector(context));
        };
      }

      if (hook) {
        if (options.functional) {
          // register for functional component in vue file
          var originalRender = options.render;

          options.render = function renderWithStyleInjection(h, context) {
            hook.call(context);
            return originalRender(h, context);
          };
        } else {
          // inject component registration as beforeCreate hook
          var existing = options.beforeCreate;
          options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
        }
      }

      return script;
    }

    var normalizeComponent_1 = normalizeComponent;

    /* script */
    const __vue_script__ = script;

    /* template */
    var __vue_render__ = function() {
      var _vm = this;
      var _h = _vm.$createElement;
      var _c = _vm._self._c || _h;
      return _c("div", [
        _c("div", { staticClass: "grid" }, [
          _c("div", { staticClass: "cell-1-1 cell--dsm" }, [
            _c("h4", [_vm._v(_vm._s(_vm.$lang.STATUSES))])
          ])
        ]),
        _vm._v(" "),
        _c(
          "button",
          { staticClass: "form-builder__send btn", on: { click: _vm.testDebug } },
          [_vm._v("Test console log for debug")]
        ),
        _vm._v(" "),
        _c("p", [_vm._v("From config JS file: " + _vm._s(this.example_data))]),
        _vm._v(" "),
        _c("p", [_vm._v("Example function: " + _vm._s(this.exampleFromFunction))]),
        _vm._v(" "),
        _c("p", [
          _c(
            "button",
            {
              staticClass: "form-builder__send btn",
              on: { click: _vm.testLoading }
            },
            [_vm._v("Test loading")]
          ),
          _vm._v(" "),
          _vm.isLoading ? _c("span", [_vm._v("is loading...")]) : _vm._e()
        ])
      ])
    };
    var __vue_staticRenderFns__ = [];
    __vue_render__._withStripped = true;

      /* style */
      const __vue_inject_styles__ = undefined;
      /* scoped */
      const __vue_scope_id__ = undefined;
      /* module identifier */
      const __vue_module_identifier__ = undefined;
      /* functional template */
      const __vue_is_functional_template__ = false;
      /* style inject */
      
      /* style inject SSR */
      

      
      var task = normalizeComponent_1(
        { render: __vue_render__, staticRenderFns: __vue_staticRenderFns__ },
        __vue_inject_styles__,
        __vue_script__,
        __vue_scope_id__,
        __vue_is_functional_template__,
        __vue_module_identifier__,
        undefined,
        undefined
      );

    // importing components
    // import { loadExternalLib } from '../utils/externalLib.js'

    function install(Vue) {

        if ( this.installed ) return
        this.installed = true

        /Vue.component('task', task);
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

    var plugin = {

        installed: false,

        install
    };

    var lang = {
        STATUSES: 'Statuses',
    };

    const state = () => ({});

    const getters = {

        task: state => name => {
            return state[name]
        },

        isLoading: (state, getters) => name => {
            const task = getters.task(name);
            return task && task.isLoading
        },
    };

    const mutations = {

        create(state, {name, data}) {
            Vue.set(state, name, {
                isLoading: false,
                data,
            });
        },

        setLoading(state, {name, status}) {
            Vue.set(state[name], 'isLoading', status);
        },
    };

    const actions = {

        restoreData({ state }, { name }) {
            const task = state[name];
            return task.exampleData || 'example-data';
        },

        testLoading({ state, commit, dispatch }, {name}) {

            return new Promise( resolve => {

                let _data;
                const task = state[name];

                commit('setLoading', {name, status:true});

                dispatch('restoreData', { name })
                    .then( data => {
                        consoleDebug('data', data);
                        return ['data-2']
                    })
                    .then( data => {
                        _data = data;
                        consoleDebug('data-2', data);
                    })
                    .finally( () => {
                       setTimeout(()=>{
                           commit('setLoading', { name, status: false });
                           resolve( _data );
                       }, 2000);
                    });
            })
        }
    };

    var taskModule = {
        state,
        getters,
        mutations,
        actions,
        namespaced: true
    };

    const awemaPlugin = {

        name, version,

        install(AWEMA) {
            //Vue.use(VueExternalPlugin)
            Vue.use(plugin);

            AWEMA._store.registerModule('task', taskModule);
            AWEMA.lang = lang;
        }
    };

    if (window && ('AWEMA' in window)) {
        AWEMA.use(awemaPlugin);
    } else {
        window.__awema_plugins_stack__ = window.__awema_plugins_stack__ || [];
        window.__awema_plugins_stack__.push(awemaPlugin);
    }

}());

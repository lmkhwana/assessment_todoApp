import Vue from 'vue'
import App from './App.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueConfirmDialog from 'vue-confirm-dialog'
import ToggleSwitch from 'vuejs-toggle-switch'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';



Vue.use(VueAxios, axios)
Vue.use(VueConfirmDialog)
Vue.use(ToggleSwitch)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

Vue.config.productionTip = false
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

new Vue({
  render: h => h(App),
}).$mount('#app')

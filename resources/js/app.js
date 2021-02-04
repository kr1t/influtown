import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import mixins from './mixins'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false
Vue.mixin(mixins)
const queryString = decodeURIComponent(window.location.search).replace('?liff.state=', '')
const params = new URLSearchParams(queryString)
Vue.prototype.$liffParams = params

import VueLazyLoad from 'vue-lazyload'
Vue.use(VueLazyLoad)

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})

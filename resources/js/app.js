import Vue from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import vuetify from '@/plugins/vuetify'
import store from '@/store'
import i18n from '@/i18n'
import AdminLayout from '@/layouts/AdminLayout'
import helpers from '@/plugins/helpers'

require('./bootstrap')

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'
InertiaProgress.init({ color: '#4B5563' })

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: name => import(`./pages/${name}`).then(({ default: page }) => {
    page.layout = page.layout === undefined ? AdminLayout : page.layout
    return page
  }),
  setup ({
    el,
    App,
    props,
    plugin,
  }) {
    Vue.use(plugin)
    Vue.use(helpers)

    Vue.mixin({ methods: { route } })

    Vue.component('InertiaHead', Head)
    Vue.component('InertiaLink', Link)

    new Vue({
      render: h => h(App, props),
      vuetify,
      store,
      i18n,
    }).$mount(el)
  },
})

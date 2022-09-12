import { defineStore } from 'pinia'
import { useLocalStorage } from '@vueuse/core'
import * as crypto from 'crypto-js'

export const useNavigationStore = defineStore('nav', {
  state: () => ({
    drawer: useLocalStorage('n$d', 1),
    drawer_page: useLocalStorage('n$dp', ''),
    module: useLocalStorage('n$m', ''),
    country: useLocalStorage('n$cu', ''),
    city: useLocalStorage('n$ci', '')
  }),
  getters: {
    get_drawer: (state) => state.drawer === 1,
    get_drawer_page: (state) => state.drawer_page === '',
    get_module: (state) => state.module,
    get_city: (state) => state.city,
    get_country: (state) => state.country
  },
  actions: {
    toggle_drawer () {
      this.drawer = this.drawer === 1 ? 0 : 1
    },
    set_drawer_page (page: string) {
      this.drawer_page = page
    },
    set_module: function (module: string) {
      this.module = module
    },
    set_city: function (city: string) {
      this.city = city
    },
    set_country: function (country: string) {
      this.country = country
    }
  }
})

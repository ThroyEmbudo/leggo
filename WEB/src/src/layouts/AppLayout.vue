<template>
  <q-layout view="hHh lpR fFf" class="shadow-2 rounded-borders">
    <q-header elevated>
      <q-toolbar class="shadow-5">
        <q-btn v-if="!q.platform.is.mobile"
               flat
               dense
               round
               :icon="nav.get_drawer ? 'move_down' : 'menu_open'"
               aria-label="Menu"
               @click="nav.toggle_drawer()" />
        <div @click="goHome()" class="logo">
          <q-img src="~assets/logo.png"
                 class="logo-icon" />
          <q-item-label class="logo-text q-pl-sm column">
            {{ title }}
          </q-item-label>
        </div>
        <q-item-section />
      </q-toolbar>
    </q-header>
    <q-drawer v-if="!$q.platform.is.mobile"
              show-if-above
              :mini="!nav.get_drawer"
              bordered
              content-class="bg-grey-1"
              :width="260"
              :breakpoint="260">
      <q-scroll-area class="fit">
        <AppDrawer />
      </q-scroll-area>
    </q-drawer>
    <q-page-container>
      <router-view />
    </q-page-container>
    <q-footer elevated
              class="bg-grey-8 text-white">
      <div>{{ copyrights }}</div>
    </q-footer>
  </q-layout>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import { useQuasar } from 'quasar'
import { useNavigationStore } from 'stores/navigation-store'
import AppDrawer from 'components/system/AppDrawer.vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'AppLayout',
  components: { AppDrawer },
  setup () {
    const q = useQuasar()
    const router = useRouter()
    const nav = useNavigationStore()
    const title = 'Leggo'
    const copyrights = q.platform.is.mobile
      ? ''
      : ''
    function goHome () {
      nav.set_drawer_page('')
      nav.set_module('home')
      void router.push('/')
    }
    return {
      q,
      nav,
      title,
      copyrights,
      goHome
    }
  }
})
</script>

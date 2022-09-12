<template>
  <q-layout view="hHh lpR fFf" class="shadow-2 rounded-borders">
    <q-header elevated>
      <q-toolbar class="shadow-5">
        <div class="logo">
          <q-img src="~assets/logo.png"
                 class="logo-icon" />
          <q-item-label class="logo-text q-pl-sm column">
            {{ title }}
          </q-item-label>
        </div>
        <q-item-section></q-item-section>
      </q-toolbar>
    </q-header>
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

export default defineComponent({
  name: 'CleanLayout',
  setup () {
    const q = useQuasar()
    const title = q.platform.is.mobile
      ? ''
      : ''
    const copyrights = q.platform.is.mobile
      ? ''
      : ''
    return {
      title,
      copyrights
    }
  }
})
</script>

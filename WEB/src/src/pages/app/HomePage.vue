<template>
  <q-page class="items-center" padding>
    <HomeComponent />
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useNavigationStore } from 'stores/navigation-store'
import HomeComponent from 'components/web/Home.vue'

export default defineComponent({
  name: 'HomePage',
  components: { HomeComponent },
  setup () {
    const navi = useNavigationStore()
    navi.set_module('home')
    navi.set_drawer_page('')
    return { }
  }
})
</script>

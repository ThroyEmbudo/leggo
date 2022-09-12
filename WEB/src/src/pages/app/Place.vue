<template>
  <q-page class="items-center" padding>
    <PlaceComponent />
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useNavigationStore } from 'stores/navigation-store'
import PlaceComponent from 'components/web/Place.vue'

export default defineComponent({
  name: 'Place',
  components: { PlaceComponent },
  setup () {
    const navi = useNavigationStore()
    navi.set_module('place')
    navi.set_drawer_page('')
    return { }
  }
})
</script>

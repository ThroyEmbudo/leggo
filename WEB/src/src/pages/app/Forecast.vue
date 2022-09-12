<template>
  <q-page class="items-center" padding>
    <ForecastComponent />
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useNavigationStore } from 'stores/navigation-store'
import ForecastComponent from 'components/web/Forecast.vue'

export default defineComponent({
  name: 'Forecast',
  components: { ForecastComponent },
  setup () {
    const navi = useNavigationStore()
    navi.set_module('forecast')
    navi.set_drawer_page('')
    return { }
  }
})
</script>

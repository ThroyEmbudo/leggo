<template>
  <q-list padding>
    <user-profile v-if="q.platform.is.mobile" />
    <q-separator v-if="q.platform.is.mobile" />
    <q-item clickable
            v-ripple
            :class="isSelected('home') ? selected_module_class : module_class"
            v-bind:class="{ selected: isSelected('home') }"
            @click="select('home')">
      <q-item-section avatar
                      class="dialog-button-icon">
        <q-icon name="home"
                :color="isSelected('home') ? selected_color : not_selected_color">
          <q-tooltip v-if="!nav.get_drawer"
                     anchor="center right"
                     self="center left"
                     :offset="[10, 10]">
            <span class="text-subtitle2">Home</span>
          </q-tooltip>
        </q-icon>
      </q-item-section>
      <q-item-section>Home</q-item-section>
    </q-item>
    <q-item clickable
            v-ripple
            :class="isSelected('forecast') ? selected_module_class : module_class"
            v-bind:class="{ selected: isSelected('forecast') }"
            @click="select('forecast')">
      <q-item-section avatar
                      class="dialog-button-icon">
        <q-icon name="sunny"
                :color="isSelected('forecast') ? selected_color : not_selected_color">
          <q-tooltip v-if="!nav.get_drawer"
                     anchor="center right"
                     self="center left"
                     :offset="[10, 10]">
            <span class="text-subtitle2">Forecast</span>
          </q-tooltip>
        </q-icon>
      </q-item-section>
      <q-item-section>Forecast</q-item-section>
    </q-item>
    <q-item clickable
            v-ripple
            :class="isSelected('place') ? selected_module_class : module_class"
            v-bind:class="{ selected: isSelected('place') }"
            @click="select('place')">
      <q-item-section avatar
                      class="dialog-button-icon">
        <q-icon name="map"
                :color="isSelected('place') ? selected_color : not_selected_color">
          <q-tooltip v-if="!nav.get_drawer"
                     anchor="center right"
                     self="center left"
                     :offset="[10, 10]">
            <span class="text-subtitle2">Place</span>
          </q-tooltip>
        </q-icon>
      </q-item-section>
      <q-item-section>Place</q-item-section>
    </q-item>
  </q-list>
</template>
<script>
import { defineComponent, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useNavigationStore } from 'stores/navigation-store'
import { useQuasar } from 'quasar'

export default defineComponent({
  name: 'AppDrawer',
  components: {  },
  setup () {
    const q = useQuasar()
    const nav = useNavigationStore()
    const router = useRouter()
    const module_class = 'module-light'
    const selected_module_class = 'selected-module-light'
    const selected_color = '#121212'
    const not_selected_color = '#7e7e7e'
    function isSelected (module) {
      return nav.get_module === module
    }
    function select (module) {
      nav.set_module(module)
      if (module === 'home') {
        router.push('/')
      } else {
        router.push(`/${module}`)
      }
    }
    return {
      q,
      nav,
      isSelected,
      select,
      module_class,
      selected_module_class,
      selected_color,
      not_selected_color
    }
  }
})
</script>

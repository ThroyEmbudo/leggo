<template>
  <div style="width: 400px; max-width: 400px;">
    <q-form ref="editor_form"
            @submit="onSave"
            @reset="onReset">
      <q-card style="width: 400px; max-width: 400px;">
        <q-toolbar>
          <div class="text-h6">
            Organization
          </div>
        </q-toolbar>
        <q-card-section style="max-height: 600px"
                        class="scroll">
          <div class="row">
            <q-input dense
                     clearable
                     label="Code"
                     class="data-entry-sm"
                     input-class="org-input"
                     autofocus
                     outlined
                     maxlength="12"
                     :rules="[organizationCodeIsRequired]"
                     v-model="editor_item.code" />
          </div>
          <div class="row">
            <q-input dense
                     clearable
                     label="Name"
                     class="data-entry-md"
                     maxlength="64"
                     outlined
                     :rules="[organizationNameIsRequired]"
                     v-model="editor_item.name" />
          </div>
          <div class="row">
            <q-input dense
                     clearable
                     label="Description"
                     class="data-entry-lg"
                     maxlength="1000"
                     autogrow
                     outlined
                     v-model="editor_item.description" />
          </div>
        </q-card-section>
        <q-card-actions align="right">
          <q-toolbar>
            <q-btn label="Reset"
                   color="secondary"
                   class="dialog-button"
                   flat
                   type="reset" />
            <q-toolbar-title />
            <q-btn label="Save"
                   color="primary"
                   class="dialog-button"
                   :disable="JSON.stringify(editor_item) === JSON.stringify(item)"
                   type="submit" />
            &nbsp;
            <q-btn label="Cancel"
                   color="red"
                   v-close-popup
                   class="dialog-button"
                   @click="onCancel()" />
          </q-toolbar>
        </q-card-actions>
      </q-card>
    </q-form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onBeforeMount } from 'vue'

export default defineComponent({
  name: 'PlaceDetails',
  props: {
    item: Object
  },
  emits: ['reset', 'save', 'cancel'],
  setup (props, {emit}) {
    const editor_item = ref<any>(null)
    onBeforeMount(() => {
      editor_item.value = Object.assign({}, props.item)
    })
    function organizationCodeIsRequired (val: string) {
      return ((val && val.length > 0) || 'Organization code is required')
    }
    function organizationNameIsRequired (val: string) {
      return ((val && val.length > 0) || 'Organization name is required')
    }
    function onReset () {
      editor_item.value = Object.assign({}, props.item)
      emit('reset')
    }
    function onSave () {
      emit('save', editor_item.value)
    }
    function onCancel () {
      emit('cancel')
    }
    return {
      organizationCodeIsRequired,
      organizationNameIsRequired,
      editor_item,
      onReset,
      onSave,
      onCancel
    }
  }
})
</script>

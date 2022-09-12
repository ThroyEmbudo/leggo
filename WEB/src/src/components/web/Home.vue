<!--suppress JSValidateTypes -->
<template>
  <div>
    <div class="col-12 ">
      <div class="row justify-center ">
        <div class="col-5 q-mr-xs">
          <q-select v-model="country" :options="opt_country" label="Country" filled ></q-select>
        </div>
        <div class="col-5 q-mr-xs">
          <q-select 
              v-model="city" 
              :options="options" 
              label="City" 
              :disable="checker(country)"
              @filter="filterFn"
              filled 
              use-input
              behavior="menu"
              @update:model-value="callApi"
            >
          </q-select>
        </div>    
      </div>
    </div>
    
    <div class="col-12 q-mt-sm" v-if="country">
        <q-img 
          :src="showImage(country)"
          style="height: 350px;"
          >
          <div class="absolute-full text-subtitle2 flex flex-center justify-center">
            {{country}} <br/>{{city}}
          </div>
        </q-img>
    </div>
    
    <div class="col-12 q-mt-sm" v-if="!checker(city)">
      <q-toolbar class="bg-green text-white q-mb-xs">
        <q-btn flat round dense icon="sunny">
        </q-btn>
        <q-toolbar-title>
          Weather Forecast
        </q-toolbar-title>
        <q-btn 
            flat 
            round 
            dense  
            class="q-mr-xs"
            @click="showAllForecast(country, city)"
          >
          <q-icon left size="3em" name="read_more"/>
          <q-tooltip
              transition-show="flip-right"
              transition-hide="flip-left"
            >
              Show all forecast for this week
            </q-tooltip>
        </q-btn>
      </q-toolbar>
      <div class="row justify-center">
        <div class="col-auto q-mr-sm q-mt-sm" v-for="row in forecast">
          <q-card class="my-card bg-primary" align="center">
            <img 
              :src="showWeatherImage(row.weather[0].icon)"
              style="width: 150px;"
              >
            <q-card-section class="flex-center">
              <div class="text-h4 text-white">{{row.main.temp}}°</div>
              <div class="text-subtitle2 text-white">{{ row.weather[0].main}} : {{row.weather[0].description}}</div>
              <div class="text-subtitle2 text-white">{{ changeStringDateTime(row.dt_txt)}} </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>

    <div class="col-12 q-mt-sm" v-if="!checker(city)">
      <q-toolbar class="bg-green text-white q-mb-xs">
        <q-btn flat round dense icon="sunny">
          
        </q-btn>
        <q-toolbar-title>
          Places
        </q-toolbar-title>
        <q-btn 
            flat 
            round 
            dense  
            class="q-mr-xs"
            @click="showAllPlaces(country, city)"
          >
          <q-icon left size="3em" name="read_more"/>
          <q-tooltip
            transition-show="flip-right"
            transition-hide="flip-left"
          >
            Search By Category
          </q-tooltip>
        </q-btn>
      </q-toolbar>
      <div class="row justify-center">
        <q-list bordered padding class="rounded-borders" style="width: 100%" v-for="place in places">

          <q-item clickable v-ripple @click="openEditor(place)">
            <q-item-section avatar top>
              <q-avatar icon="location_on" color="primary" text-color="white" />
            </q-item-section>

            <q-item-section>
              <q-item-label lines="1">{{ place.name}}</q-item-label>
              <q-item-label caption>{{place.location.formatted_address}}</q-item-label>
            </q-item-section>

            <q-item-section side>
              <q-icon name="info" color="green" />
            </q-item-section>
          </q-item>

        </q-list>
      </div>
    </div>
    
    <q-dialog v-model="editor"
      auto-close 
      @keydown.esc="editor=false">
          <q-card class="my-card" flat bordered>
            <q-img
              src="https://cdn.quasar.dev/img/parallax2.jpg"
            />
            <q-card-section>
              <div class="text-overline text-orange-9">{{ editor_item.categories[0].name}}</div>
              <div class="text-h5 q-mt-sm q-mb-xs"> {{ editor_item.name }} </div>
              <div class="text-caption text-grey">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              </div>
            </q-card-section>
            
            <q-list>
              <q-item clickable>
                <q-item-section avatar>
                  <q-icon color="primary" name="home" />
                </q-item-section>

                <q-item-section>
                  <q-item-label>{{ editor_item.location.formatted_address }}</q-item-label>
                  <q-item-label caption>Address</q-item-label>
                </q-item-section>
              </q-item>

              <q-item clickable>
                <q-item-section avatar>
                  <q-icon color="red" name="pin_drop" />
                </q-item-section>

                <q-item-section>
                  <q-item-label>{{ editor_item.geocodes.main.latitude }}, {{ editor_item.geocodes.main.longitude }} </q-item-label>
                  <q-item-label caption>Geocode</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            
          </q-card>
    </q-dialog>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, Ref, onMounted } from 'vue'
import { useQuasar, QDialog } from 'quasar'
import {useRouter, useRoute} from 'vue-router'
import { useNavigationStore } from 'src/stores/navigation-store'
import PlaceDetails from 'components/web/PlaceDetails.vue'
import axios from 'axios'
import { store } from 'quasar/wrappers'
import moment from 'moment'
import { Dialog } from 'quasar'


export default defineComponent({
  name: 'Home',
  components:  { PlaceDetails }, 
  setup () {
    const q = useQuasar()
    const api = axios;
    const router = useRouter()
    const url = "http://openweathermap.org/img/wn/10d@2x.png"
    const nav = useNavigationStore()

    const table_header = q.dark.mode ? 'table-header-dark' : 'table-header-light'
    const country = nav.get_country ?  nav.get_country : ref('JAPAN')
    const city = nav.get_city ?  nav.get_city : ref('TOKYO')
    const opt_country = ['JAPAN']
    
    const stringOptions = ['TOKYO', 'YOKOHAMA', 'KYOTO', 'OSAKA', 'SAPPORO', 'NAGOYA']
    const options = ref(stringOptions)

    
    const forecast: Ref<any[]> = ref([])
    const places: Ref<any[]> = ref([])

    const editor = ref(false)
    const editor_mode = ref('new')
    const editor_item = ref<any>()

    var loading = false

    onMounted(() => {
      callApi()
      //nav.set_city("")
      // nav.set_country("")
    });
    

    function filterFn (val:any, update:any) {
      if (val === '') {
        update(() => {
          options.value = stringOptions
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        options.value = stringOptions.filter(v => v.toLowerCase().indexOf(needle) > -1)
      })
    }

    function checker(data:string){
      if(!data){
        return true
      }
      else{
        return false
      }
    }

    function showAllForecast(country:string, city:string){
      nav.set_city(city)
      nav.set_country(country)
      void router.push('forecast')
    }

    function showAllPlaces(country:string, city:string){
      nav.set_city(city)
      nav.set_country(country)
      void router.push('place')
    }

    function changeStringDateTime(dateString:any){
      if (dateString) {
           return moment(String(dateString)).format('MMMM Do YYYY, h:mm:ss a')
          }
    }

    function callApi(){
      api.post("/api/forecast",{
           country: nav.get_country ?  nav.get_country : country.value,
           city: nav.get_city ?  nav.get_city : city.value
        })
        .then(response => {
          var count = 0;
          forecast.value = []
          response.data.forEach((v:any) => {
            count = count + 1;
            if(count <= 8){
              forecast.value.push({
              clouds: v.clouds,
              main: v.main,
              weather: v.weather,
              wind: v.wind,
              dt_txt: v.dt_txt
            })
            }
          })
          
      })

      api.post("/api/places",{
        country: nav.get_country ?  nav.get_country : country.value,
           city: nav.get_city ?  nav.get_city : city.value
        })
        .then(response => {
          var count = 0;
          places.value = []
          
          response.data.forEach((v:any) => {
            
            count = count + 1;
            if(count <= 8){
              places.value.push({
              categories: v.categories,
              fsq_id: v.fsq_id,
              geocodes: v.geocodes,
              location: v.location,
              timezone: v.timezone,
              name: v.name
            })
            }
          })
          
      })

    }

    function showImage(country:string){
      if(!country){

      }else if(country == "JAPAN"){
        return new URL('/src/assets/images/japan.jpg', import.meta.url).href
      }
        
    }

    function showWeatherImage(icon:string){
      return "https://openweathermap.org/img/wn/"+icon+"@2x.png"  
    }

    function openEditor(data:any) {
      editor_item.value = data
      editor.value = true
    }

    
    return {
      q,
      api,
      forecast,
      filterFn,
      changeStringDateTime,
      checker,
      showImage,
      showWeatherImage,
      stringOptions,
      country,
      city,
      loading,
      opt_country,
      options,
      url,
      places,
      table_header,
      callApi,
      editor_item,
      editor,
      editor_mode,
      showAllForecast,
      showAllPlaces,
      openEditor
    }
  }
})
</script>

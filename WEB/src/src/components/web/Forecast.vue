<!--suppress JSValidateTypes -->
<template>
  <div>
    <div class="col-12 ">
      <div class="row justify-center ">
        <div class="col-5 q-mr-xs">
          <q-select 
            v-model="country" 
            :options="opt_country" 
            label="Country" 
            filled 
            >
          </q-select>
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
          <div class="absolute-full text-subtitle2 flex flex-center">
            {{country}}
          </div>
        </q-img>
    </div>
    
    <div class="col-12 q-mt-sm" v-for="daterow in avaiDate">
      <q-toolbar class="bg-green text-white q-mb-xs" >
        <q-btn flat round dense icon="calendar_month">
        </q-btn>
        <q-toolbar-title>
          {{ changeStringDate(daterow) }}
        </q-toolbar-title>
      </q-toolbar>
      <div class="row justify-center">    
        <div class="col-auto" v-for="row in forecast">
          
          <q-card class="my-card bg-primary q-mr-sm q-mt-sm" align="center" v-if="changeStringDate(returnDate(row.dt_txt)) == changeStringDate(daterow)">
            <img 
              :src="showWeatherImage(row.weather[0].icon)"
              style="width: 150px;"
              >
            <q-card-section class="flex-center">
              <div class="text-h4 text-white">{{row.main.temp}}°</div>
              <div class="text-subtitle2 text-white">{{ row.weather[0].main}} : {{row.weather[0].description}}</div>
              <div class="text-subtitle2 text-white">{{changeStringDateTime(row.dt_txt)}}</div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>
    
    
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, Ref, onMounted } from 'vue'
import { useQuasar } from 'quasar'
import {useRouter, useRoute} from 'vue-router'
import axios from 'axios'
import { useNavigationStore } from 'src/stores/navigation-store'
import moment from 'moment';

export default defineComponent({
  name: 'Forecast',
  setup () {
    const q = useQuasar()
    const api = axios;
    const store = useNavigationStore()
    const router = useRouter()
    const url = "http://openweathermap.org/img/wn/10d@2x.png"
    
    const country = store.get_country ?  store.get_country : ref('JAPAN')
    const city = store.get_city ?  store.get_city : ref('TOKYO')
    const opt_country = ['JAPAN']
    
    const stringOptions = ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya']
    const options = ref(stringOptions)

    const avaiDate: Ref<any[]> = ref([])

    const forecast: Ref<any[]> = ref([])
    const places: Ref<any[]> = ref([])

    var loading = false

    onMounted(() => {
      callApi()
    });

    function splitDate(forecast:any){
      console.log(forecast._rawValue)
      avaiDate.value = []
      for(var row in forecast._rawValue){
        let temp_date = forecast._rawValue[row].dt_txt
        console.log(temp_date.split(" ")[0])
        if(avaiDate.value.indexOf(temp_date.split(" ")[0]) === -1){
          avaiDate.value.push(temp_date.split(" ")[0])
        }
      }
      console.log(avaiDate)
    }



    function changeStringDate(dateString:any){
      if (dateString) {
           return moment(String(dateString)).format('MMMM Do YYYY')
          }
    }

    function changeStringDateTime(dateString:any){
      if (dateString) {
           return moment(String(dateString)).format('MMMM Do YYYY, h:mm:ss a')
          }
    }

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

    function returnDate(dateString:string){
      return dateString.split(" ")[0]
    }

    function checker(data:string){
      if(!data){
        return true
      }
      else{
        return false
      }
    }

    function callApi(){
      api.post("/api/forecast",{
           country: store.get_country ?  store.get_country : country.value,
           city: store.get_city ?  store.get_city : city.value
        })
        .then(response => {
          forecast.value = []
          response.data.forEach((v:any) => {
              forecast.value.push({
              clouds: v.clouds,
              main: v.main,
              weather: v.weather,
              wind: v.wind,
              dt_txt: v.dt_txt
            })
          })
          splitDate(forecast)
      })

    }

    function showImage(country:string){
      if(!country){

      }else if(country == "JAPAN"){
        return new URL('/src/assets/images/japan.jpg', import.meta.url).href
      }
        
    }

    function showWeatherImage(icon:string){
      console.log("https://openweathermap.org/img/wn/"+icon+"@2x.png")
      return "https://openweathermap.org/img/wn/"+icon+"@2x.png"  
    }

    
    return {
      q,
      api,
      forecast,
      changeStringDate,
      filterFn,
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
      callApi,
      returnDate,
      avaiDate,
      changeStringDateTime
    }
  }
})
</script>

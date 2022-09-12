import { RouteRecordRaw } from 'vue-router'
import * as path from 'path'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/AppLayout.vue'),
    children: [
      { name: 'home', path: '', component: () => import('pages/app/HomePage.vue') },
      { name: 'forecast', path: '/forecast', component: () => import('pages/app/Forecast.vue') },
      { name: 'place', path: '/place', component: () => import('pages/app/Place.vue') }
    ],
    meta: { auth: false }
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('layouts/PlainLayout.vue'),
    children: [
      { path: '/:catchAll(.*)*', component: () => import('pages/system/ErrorNotFound.vue') }
    ]
  }
]

export default routes

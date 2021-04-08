<template>
  <q-layout view="hhh lpR lff">
    <q-header reveal elevated class="bg-primary text-white" style="height:100px">
      <q-toolbar>
        <q-btn flat @click="left = !left" round dense icon="menu" />
        <q-toolbar-title>SISTEMA DE MONITOREO</q-toolbar-title>
        <q-toolbar-title>mhernandez/administrador</q-toolbar-title>

       <picture>
            <img class="q-mt-md q-mr-sm responsive" width="10%" src="~assets/quasar-logo-full.svg">
      </picture>


        <q-btn round size="sm" color="info" icon="fa fa-times-circle" @click="logout" />
      </q-toolbar>
    </q-header>

    <q-drawer
      :width="275"
      show-if-above
      v-model="left"
      side="left"
      bordered
      content-class="bg-grey-4"
    >
      <q-scroll-area class="fit">
        <q-list style="margin-top: 0px;">
          <q-card class="my-card bg-grey-1">
            <q-list>
              <q-item clickable to="/" exact>
                <q-item-section avatar>
                  <q-icon color="primary" name="fas fa-home" />
                </q-item-section>

                <q-item-section>
                  <q-item-label>Home </q-item-label>
                  <q-item-label caption>Dashboard.</q-item-label>
                </q-item-section>
              </q-item>
              
             
              <q-expansion-item
                expand-separator
                icon="fas fa-tasks"
                label="Procesos"
                caption="Procesos del Sistema"
                header-class="text-primary"
              >
                <q-list>
                  <q-card bordered class="my-card my-card bg-grey-1 shadow-5">
                    <q-card-section>
                      <q-item clickable to="Clientes"  active-class="tab-active">
                      <q-item-section avatar>
                          <q-icon color="secondary" name="fa fa-user" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Clientes</q-item-label>
                          <q-item-label  caption>Clientes</q-item-label>
                        </q-item-section>
                      </q-item>
                      
                      
            

                    </q-card-section>
                  </q-card>
                </q-list>

              </q-expansion-item>


            </q-list>
          </q-card>
        </q-list>
      </q-scroll-area>

      <q-img class="absolute-top" src="~assets/bg_avatar.png" style="height: 0px">

      </q-img>
    </q-drawer>

    <q-page-container>

      <div class="q-pa-sm">
        <div class="q-gutter-y-md  bg-primary items-center">
           <div class="row flex items-center ">
              <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs text-white text-h5 items-center">
                <font style="text-align:center; size:20px;"><p> nombre_pagina </p></font>
              </div>
          </div>
        </div>
      </div>


      <router-view />
      <q-dialog
        v-model="dialog"
        persistent
        :maximized="true"
        transition-show="slide-up"
        transition-hide="slide-down"
      >
        <q-card class="bg-primary text-white">
          <q-card-section>
            <div class="text-h6">Alert</div>
          </q-card-section>

          <q-card-section>Sesión finalizada favor vuelva a iniciar sesion en el siguiente enlace</q-card-section>
        </q-card>
      </q-dialog>
    </q-page-container>

    <q-footer elevated class="bg-black text-white">
      <q-toolbar>
        <p>CONAMYPE &copy; Todos los derechos reservados</p>
      </q-toolbar>
    </q-footer>
  </q-layout>
</template>


<script lang="ts">
import EssentialLink from 'components/EssentialLink.vue'

const linksData = [
  {
    title: 'Docs',
    caption: 'quasar.dev',
    icon: 'school',
    link: 'https://quasar.dev'
  },
  {
    title: 'Github',
    caption: 'github.com/quasarframework',
    icon: 'code',
    link: 'https://github.com/quasarframework'
  },
  {
    title: 'Discord Chat Channel',
    caption: 'chat.quasar.dev',
    icon: 'chat',
    link: 'https://chat.quasar.dev'
  },
  {
    title: 'Forum',
    caption: 'forum.quasar.dev',
    icon: 'record_voice_over',
    link: 'https://forum.quasar.dev'
  },
  {
    title: 'Twitter',
    caption: '@quasarframework',
    icon: 'rss_feed',
    link: 'https://twitter.quasar.dev'
  },
  {
    title: 'Facebook',
    caption: '@QuasarFramework',
    icon: 'public',
    link: 'https://facebook.quasar.dev'
  },
  {
    title: 'Quasar Awesome',
    caption: 'Community Quasar projects',
    icon: 'favorite',
    link: 'https://awesome.quasar.dev'
  }
];

import { defineComponent, ref } from '@vue/composition-api';

export default defineComponent({
  name: 'MainLayout',
  components: { EssentialLink },
  setup() {
    const leftDrawerOpen = ref(false);
    const essentialLinks = ref(linksData);
    const left =ref(false);
    

    return {leftDrawerOpen, essentialLinks, left}
  }
});
</script>

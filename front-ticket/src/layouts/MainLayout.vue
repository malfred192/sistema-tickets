<template>
  <q-layout view="hhh lpR lff">
    <q-header reveal elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn flat @click="left = !left" round dense icon="menu" />
        <q-toolbar-title>SISTEMA TICKETS</q-toolbar-title>

        <q-btn round size="sm" color="info" icon="fas fa-sign-out-alt" @click="logout" />
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
        <q-list style="margin-top: 150px;">
          <q-card class="my-card bg-grey-1">
            <q-list>
              <q-item clickable to="/" exact>
                <q-item-section avatar>
                  <q-icon color="primary" name="fas fa-home" />
                </q-item-section>

                <q-item-section>
                  <q-item-label>Inicio</q-item-label>
                  <q-item-label caption>Dashboard.</q-item-label>
                </q-item-section>
              </q-item>
               <q-expansion-item
                expand-separator
                icon="engineering"
                label="MANTENIMIENTOS"
                caption="Mantenimientos del Sistema"
                header-class="text-primary"
              >
                <q-list>
                  <q-card bordered class="my-card my-card bg-grey-1 shadow-5">
                    <q-card-section>
                      <q-item clickable to="quinquenio">
                        <q-item-section avatar>
                          <q-icon color="secondary" name="fas fa-user" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Usuarios</q-item-label>
                          <q-item-label caption>Gestión de Usuarios</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable to="proceso">
                        <q-item-section avatar>
                          <q-icon color="accent" name="fas fa-signal" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Prioridad</q-item-label>
                          <q-item-label caption>Prioridad de Tickets</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable to="perspectiva-objetivo">
                        <q-item-section avatar>
                          <q-icon color="positive" name="download_done" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Estados</q-item-label>
                          <q-item-label caption>Estados de Tickets</q-item-label>
                        </q-item-section>
                      </q-item>
                    </q-card-section>
                  </q-card>
                </q-list>
              </q-expansion-item>
              <q-expansion-item
                expand-separator
                icon="fas fa-cogs"
                label="PROCESOS"
                caption="Procesos"
                header-class="text-primary"
              >
                <q-list>
                  <q-card bordered class="my-card my-card bg-grey-1 shadow-5">
                    <q-card-section>
                      <q-item clickable to="quinquenio">
                        <q-item-section avatar>
                          <q-icon color="secondary" name="local_activity" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Crear Tickets</q-item-label>
                          <q-item-label caption>Generar Ticket</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable to="proceso">
                        <q-item-section avatar>
                          <q-icon color="accent" name="fas fa-cogs" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Gestión de Tickets</q-item-label>
                          <q-item-label caption>Gestión de Tickets.</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                    </q-card-section>
                  </q-card>
                </q-list>
              </q-expansion-item>
               <q-expansion-item
                expand-separator
                icon="print"
                label="REPORTES"
                caption="Reportes"
                header-class="text-primary"
              >
                <q-list>
                  <q-card bordered class="my-card my-card bg-grey-1 shadow-5">
                    <q-card-section>
                      <q-item clickable to="quinquenio">
                        <q-item-section avatar>
                          <q-icon color="secondary" name="plagiarism" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Consultar Tickets</q-item-label>
                          <q-item-label caption>Consultar Tickets</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                    </q-card-section>
                  </q-card>
                </q-list>
              </q-expansion-item>
            </q-list>
          </q-card>
        </q-list>
      </q-scroll-area>

      <q-img
        class="absolute-top"
        src="https://us.123rf.com/450wm/elvil/elvil1601/elvil160100018/51546002-abstract-polygonal-geometric-facet-dark-blue-vector-background-wallpaper-illustration.jpg?ver=6"
        style="height: 150px"
      >
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img
              src="https://bpxk748cf4n2yzlvi1rkrh61-wpengine.netdna-ssl.com/wp-content/uploads/sites/17/2018/06/Avatar-Unisex-Default-253x300.jpg"
            />
          </q-avatar>
          <div class="text-weight-bold">Manuel Hernández</div>
          <div>Administrador</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
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
        <p>Manuel Hernández &copy; Todos los derechos reservados</p>
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

import { loadingScreenMixin } from "../mixins/loadingScreenMixin";
import { defineComponent, ref } from '@vue/composition-api';

export default defineComponent({
  name: 'MainLayout',
  components: { EssentialLink },
  mixins: [loadingScreenMixin],
  setup() {
    const leftDrawerOpen = ref(false);
    const essentialLinks = ref(linksData);
    const left =ref(false);
    

    return {leftDrawerOpen, essentialLinks, left}
  },
  methods: {
    logout() {
      this.$q
        .dialog({
          title: "Confirme que desea cerrar sesión",
          message: "¿Esta seguro que desea cerrar la sesión?",
          cancel: true,
          position: "top",
          ok: {
            push: true,
            color: "negative"
          }
        })
        .onOk(() => {
          this.$axios
            .get(process.env.API_URL + "user/logout")
            .then(response => {
              this.$store.dispatch("auth/cerrarSesion");
              //window.location = "http://google.com";
            })
            .catch(error => {
              /* if (error.response.data.code === 23000) {
                this.$q.notify({
                  message:
                    "No es posible eliminar, hay registros que dependen de él",
                  color: "negative"
                });
              } */
            });
        });
    }
  }
});
</script>

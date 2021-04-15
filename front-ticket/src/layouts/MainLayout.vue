<template>
  <q-layout view="hhh lpR lff">
    <q-header reveal elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn flat @click="left = !left" round dense icon="menu" />
        <q-toolbar-title>SISTEMA TICKETS</q-toolbar-title>

              <q-img class="absolute-top" src="~assets/bg_front.jpg" style="height: 0px">
              </q-img>


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
                v-if="rol==1"
                expand-separator
                icon="engineering"
                label="MANTENIMIENTOS"
                caption="Mantenimientos del Sistema"
                header-class="text-primary"
              >
                <q-list>
                  <q-card bordered class="my-card my-card bg-grey-1 shadow-5">
                    <q-card-section>
                      <q-item clickable to="quinquenio"
                       v-if="rol==1">
                        <q-item-section avatar>
                          <q-icon color="secondary" name="fas fa-user" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Usuarios</q-item-label>
                          <q-item-label caption>Gestión de Usuarios</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable to="proceso"
                      v-if="rol==1">
                        <q-item-section avatar>
                          <q-icon color="accent" name="fas fa-signal" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Prioridad</q-item-label>
                          <q-item-label caption>Prioridad de Tickets</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable to="perspectiva-objetivo"
                      v-if="rol==1">
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
                      <q-item clickable to="ticket"  v-if="rol==2">
                        <q-item-section avatar>
                          <q-icon color="secondary" name="local_activity" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Tickets</q-item-label>
                          <q-item-label caption>Crear Ticket</q-item-label>
                        </q-item-section>
                      </q-item>
                      <q-separator />
                      <q-item clickable to="gestionarticket"
                      v-if="rol==1">
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
          <div class="text-weight-bold">{{ this.$store.state.auth.usuario.name}}</div>
          <div>{{ this.$store.state.auth.usuario.rol }}</div>
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
import { loadingScreenMixin } from "../mixins/loadingScreenMixin";
import { defineComponent, ref } from '@vue/composition-api';
import Vuex from 'vuex';
import axios from 'axios';
import { SessionStorage  } from 'quasar'



export default defineComponent({
  name: 'MainLayout',
  components: {  },
  mixins: [loadingScreenMixin],
  setup() {
    const leftDrawerOpen = ref(false);
    const left =ref(false);
    const rol=ref(SessionStorage.getItem("rol"));
    const dialog=ref(false);
    

    return {leftDrawerOpen, left, rol, dialog}
  },
  methods: {
   async logout() {
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
          this.$axios.defaults.headers.common['Authorization'] = `Bearer ${this.$store.state.auth.access_token}`
          this.$axios
            .post(process.env.API_URL + "logout")
            .then(response => {
             this.$store.dispatch("auth/cerrarSesion");
                SessionStorage.remove("key")
                SessionStorage.remove("usuario")
                SessionStorage.remove("authenticated")
                SessionStorage.remove("rol")
             this.$router.push({name:'login'});
            })
            .catch(error => {
               if (error.response.status === 401) {
                this.$router.push({name:'login'});
              } 
            });
        }); //Fin de la opcion OK
    }
  },
 async mounted(){

     try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.post(process.env.API_URL + `validarusuario`);
        if(JSON.stringify(json.data)!='[]'){
          
          let user
         
           user={
              usu:{
                email:json.data.email,
                name:json.data.name,
                rol:json.data.rol,
                rol_id:json.data.rol_id,
                usu_id:json.data.usu_id
              },
               access_token:token
            }
  
    
          await this.$store.dispatch("auth/setUser", user);
         }
     } catch (error) {
       console.log(error);
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }



  }
});
</script>

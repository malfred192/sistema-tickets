<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex flex-center">
        <div style='background-image: url("../img/bg_front.jpg");no-repeat center center fixed;
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;' 
            class="window-height window-width row justify-center items-center "
        >
          <q-card v-bind:style="$q.screen.lt.sm?{'width': '80%'}:{'width':'30%'}">
            <q-card-section class="row justify-center">
              <div class="text-center q-pt-lg">
                <div class="col text-h6 ellipsis">
                  <h4>Sistema de Tickets</h4> 
                </div>
              </div>
            </q-card-section>
            <q-card-section>
              <q-form
                class="q-gutter-md"
                @submit.prevent="submit"
              >

                <q-input
                  type="text"
                  filled
                  v-model="usuario.email"
                  label="Correo electrónico*"
                  lazy-rules
                  @blur="$v.usuario.email.$touch"  :error="$v.usuario.email.$error"
                  :error-message="`${checkErr('Email', $v.usuario.email)}`"
                  hint="Formato: admin@admin.com"
                  unmasked-value
                >
                <template v-slot:prepend>
                      <q-icon name="fas fa-at" />
                    </template>
                </q-input>

                <q-input
                  type="password"
                  filled
                  v-model="usuario.password"
                  label="Contraseña *"
                  lazy-rules
                  @blur="$v.usuario.password.$touch"  :error="$v.usuario.password.$error"
                  :error-message="`${checkErr('Password', $v.usuario.password)}`"
                >
                <template v-slot:prepend>
                      <q-icon name="lock" />
                    </template>
                </q-input>

                <div class="row justify-center">
                  <q-btn label="Iniciar Sesión" size="lg" type="submit" color="primary"/>
                </div>
                <q-card-section class="text-center">
                   <div class="row justify-center">
                    <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                      <q-btn flat label="Registrarse" size="md" color="primary"  @click="modalRegistro=true" outline />
                    </div>
                  </div>
              </q-card-section>
              </q-form>
            </q-card-section>
          </q-card>
           <!-- ############################################################ MODAL PARAM. RESPUESTAS ######################################################################## -->

      <q-dialog v-model="modalRegistro" persistent>
        <q-card style="width: 800px; max-width: 90vw;">
          <q-bar dark class="bg-primary text-white">
            <div class="col text-center text-weight-bold">
              <div>REGISTRO DE USUARIO</div>
            </div>
            <q-space />
            <q-btn dense flat icon="close" v-close-popup>
              <q-tooltip>Cerrar</q-tooltip>
            </q-btn>
          </q-bar>

          <!-- Formulario importado -->
          <q-card-section>
            <div class="row"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
                  <registro v-on:close-modal="cerrarModal(1)"  @mensaje="mensaje = $event"></registro> 
              </div>
            </div>
          </q-card-section>
        </q-card>
      </q-dialog>

      <!-- ############################################################ FIN MODAL PARAM. RESPUESTAS ######################################################################## -->

      <!-- #############################################################  MODAL MENSAJE  ############################################### -->
      <q-dialog v-model="modalMensaje">
      <q-card>
        <q-card-section>
          <div class="text-h6">Estimado Usuario</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          {{mensaje}}
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="OK" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
      <!-- ############################################################################################################################# -->
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { SessionStorage } from 'quasar'
import registro from './formRegistro.vue';
import moment from 'moment'; //moment Js
import { errorCheckMsjMixin } from "../../mixins/errorCheckMsjMixin";
import {notifyMixin} from "../../mixins/notifyMixin";
import { loadingScreenMixin } from "../../mixins/loadingScreenMixin";


  import {
    required,
    minValue,
    between,
    helpers,
    email,
    requiredIf,
  } from "vuelidate/lib/validators";

  import axios from 'axios';
  import Vuex from "vuex"; //importando vuex;
    export default {
      components:{
        registro
      },
      name: 'login',
      mixins: [notifyMixin, errorCheckMsjMixin, loadingScreenMixin ],
        data() {
            return {
                usuario:{
                  email: "malfred192@gmail.com",
                  password: "123456"
                },
                modalRegistro:false,
                modalResetPassword:false,
                modalMensaje:false,
                mensaje:null,

            }
        },
        validations() {
        return {
          usuario: {
            email: {
              required,
              email
            },
            password: {
              required
            }
          }
        };
      },
      methods: {
          //Vuex
          ...Vuex.mapActions('auth',['login']),
          ...Vuex.mapActions('rol',['roles']),

        async submit(){
            this.$v.$touch();
            if (!this.$v.$invalid) {
              this.$q.loading.show({
                message: 'Verificando Credenciales, espere por favor...</span>'
              })

              //Peticiones a vuex
              await this.login(this.usuario);
              if(this.authenticated==false){
                this.mostrar_alerta('Email y/o contraseña incorrectos. Por favor verifique la información',3);
                this.usuario.email=null;
                this.usuario.password=null;
              }else{
                SessionStorage.set("key", this.$store.state.auth.access_token)
                SessionStorage.set("usuario", this.$store.state.auth.usuario)
                SessionStorage.set("authenticated", this.$store.state.auth.authenticated)
                SessionStorage.set("rol", this.$store.state.auth.usuario.rol_id)
                 SessionStorage.set("usu_id", this.$store.state.auth.usuario.usu_id)
                this.$router.push({name:'inicio'});
              }
             this.mostrar_alerta('Sesión iniciada con éxito, !Bienvenido¡')
             this.$q.loading.hide();
            }
            
          },
          cerrarModal(opc=null){

            if(opc==1){
              this.modalRegistro=false;
            }else if(opc==2){
              this.modalResetPassword=false;
            }
            this.modalMensaje=true;

          }
       
      },
      computed: {
        //Vuex
          ...Vuex.mapState('auth',['authenticated']),
      },
     async mounted(){
        if(this.authenticated==true){
           this.$router.push({name:'inicio'});
        }
      }
    }
</script>

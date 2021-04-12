<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex flex-center">
        <div style='background-image: url("../img/bg_avatar.png");no-repeat center center fixed;
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;' 
            class="window-height window-width row justify-center items-center "
        >
          <q-card v-bind:style="$q.screen.lt.sm?{'width': '80%'}:{'width':'30%'}">
            <q-card-section class="row justify-center">
            <!--  <img
                alt="Conamype"
                src="~assets/logo_conamype.png"
                v-bind:style="$q.screen.lt.sm?{'width': '50%'}:{'width':'70%'}"
              > -->
              <div class="text-center q-pt-lg">
                <div class="col text-h6 ellipsis">
                  Sistema de Monitoreo
                </div>
              </div>
              <br>

            </q-card-section>
            <q-card-section>
              <q-form
                class="q-gutter-md"
                @submit.prevent="submit"
              >
                <q-select
                  :dense="true"
                  filled
                  v-model="user"
                  use-input
                  :options="optionUsers"
                  option-value="usr_id"
                  option-label="tecnico"
                  input-debounce="0"
                  label="Usuario"
                  clearable
                  @filter="filterFn"
                  @blur="$v.user.$touch"
                      :error="$v.user.$error" :error-message="`${checkErr('Usuario', $v.user)}`"
                >
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">Sin resultados</q-item-section>
                    </q-item>
                  </template>
                </q-select>

                <div class="row justify-center">
                  <q-btn label="Iniciar Sesión" size="lg" type="submit" color="primary"/>
                </div>
              </q-form>
            </q-card-section>
          </q-card>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
var optionUsers=[]
import moment from 'moment'; //moment Js
import { errorCheckMsjMixin } from "../../mixins/errorCheckMsjMixin";
import {notifyMixin} from "../../mixins/notifyMixin";
import { loadingScreenMixin } from "../../mixins/loadingScreenMixin";


  import {
     required, minValue, between, helpers, requiredIf,sameAs,minLength,email
  } from "vuelidate/lib/validators";

  import axios from 'axios';
  import Vuex from "vuex"; //importando vuex;
    export default {
      components:{
        
      },
      name: 'login',
      mixins: [notifyMixin, errorCheckMsjMixin, loadingScreenMixin ],
        data() {
            return {
                password:null,
                rePassword:null,
                usuario_id:null, 
                mensaje:null,
                user:null,
                optionUsers:{},
                 usuario:{
                  usuario: null,
                  password: null
                },
            }
        },
        validations() {
        return {
         user: {
           
              required
            
          }

        };
    
  },
      methods: {
          //Vuex
          ...Vuex.mapActions('auth',['loginconamype']),

        filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.optionUsers = optionUsers;
        })
        return
      }

       update(() => {
        const needle = val.toLowerCase();
        this.optionUsers=optionUsers.filter(busqueda=>busqueda.tecnico.toLowerCase().includes(needle));
      })
    },

        async submit(){
            this.$v.$touch();
            if (!this.$v.$invalid) {
              this.$q.loading.show({
                message: 'Espere por favor...</span>'
              })

              this.usuario={
                usuario:parseInt(this.user.usr_id)
              },

              console.log(this.usuario);

              await this.loginconamype(this.usuario);

              if(this.authenticated==false){
                this.mostrar_alerta('Usuario y/o contraseña incorrectos. Por favor verifique la información',3);
                this.usuario.usuario=null;
                this.usuario.password=null;
              }else{
                this.$router.push({name:'inicio'});
              }
             this.mostrar_alerta('Sesión iniciada con éxito, !Bienvenido¡')

           /*   const params={
                usuario:  {
                            clave: this.password
                          },
                usuario_id: this.usuario_id
              }

            try {
              const response = await axios.put(process.env.API_URL +
                    `login/`+this.usuario_id,params);
              if (response.status === 200) {
                this.mostrar_alerta('La contrzaseña se reestableció exitosamente', 1);
                this.$router.push('/Login');
                
              }
            
            } catch (error) {
            }*/
             /* await this.login(this.usuario);
              if(this.authenticated==false){
                this.mostrar_alerta('Usuario y/o contraseña incorrectos. Por favor verifique la información',3);
                this.usuario.usuario=null;
                this.usuario.password=null;
              }else{
                this.$router.push({name:'inicio'});
                this.mostrar_alerta('Sesión inciada con éxito, !Bienvenido¡')
              }*/
             this.$q.loading.hide();
            }
            
          },
       
      },
      computed: {
        //Vuex
          ...Vuex.mapState('auth',['authenticated']),
      },
     async mounted(){

       try {
            const json = await axios
            .get(
              process.env.API_URL +
              `user/getusers`
            );
            this.optionUsers=json.data.items;
            optionUsers=json.data.items;
              
        } catch (err) {
          console.log(err);
        }


          
        /*  await axios.get(
                process.env.API_URL +
                `login/verificaridentidad`,{params}
              )
              .then(json => (
                this.usuario_id=json.data.usuario_id
                ))
              .catch(function (res) {
                if (res instanceof Error) {
                  console.log(res.response)
                 if(res.response.status==500){
                   //this.mostrar_alerta('res.response.data.message')
                   //this.mensaje=res.response.data.message;
                  
                 }
                } else {
                  console.log(res);
                }
              }); */

        if(this.authenticated==true){
           this.$router.push({name:'inicio'});
        }
      }
    }
</script>

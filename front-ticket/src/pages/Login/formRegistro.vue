<template>
  <div class="q-gutter-md q-pt-lg">
    <q-form  class="q-gutter-md" @submit.prevent="submit"  autofocus>
      <div class="row flex">
        <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
          <strong>Estimado usuario, por favor digite la información del formulario</strong>
        </div>
      </div>
      <div class="row flex">
        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="nombres" type="text" label="Nombres *"
            @blur="$v.nombres.$touch"  :error="$v.nombres.$error"
            :error-message="`${checkErr('Nombres', $v.nombres)}`"
            />
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="apellidos" label="Apellidos *" type="text"
            @blur="$v.apellidos.$touch" 
            :error="$v.apellidos.$error" :error-message="`${checkErr('Apellidos', $v.apellidos)}`"
           />
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="correo" label="Correo Electrónico *" type="email"
            @blur="$v.correo.$touch" 
            :error="$v.correo.$error" :error-message="`${checkErr('Correo Electrónico', $v.correo)}`" 
            @change="verificarInformacion(3)"
            />
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="correoConfirme" label="Confirme Correo Electrónico *" type="email"
            @blur="$v.correoConfirme.$touch" 
            :error="$v.correoConfirme.$error" :error-message="`${checkErr('Confirme Correo Electrónico', $v.correo)}`" 
            />
        </div>
       
        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="password" filled :type="isPwd ? 'password' : 'text'" hint="Contraseña"
           @blur="$v.password.$touch" 
            :error="$v.password.$error" :error-message="`${checkErr('Contraseña', $v.password)}`" >
            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input  :dense="true" v-model="rePassword" filled :type="isPwd1 ? 'Password' : 'text'" hint="repita Contraseña"
           @blur="$v.rePassword.$touch" 
            :error="$v.rePassword.$error" :error-message="`${checkErr('reconfirmar Contraseña', $v.rePassword)}`" >
            <template v-slot:append>
              <q-icon
                :name="isPwd1 ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd1 = !isPwd1"
              />
            </template>
          </q-input>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                    <q-select  filled v-model="rol" label="Rol *" :options="rolOptions"  :dense="true"  
                        option-value="id"
                        option-label="nombre"
                        option-disable="inactive"
                        emit-value
                        map-options
                        clearable
                        :readonly="es_ver"
                        @blur="$v.rol.$touch" :error="$v.rol.$error" :error-message="`${checkErr('Rol', $v.rol)}`" 
                      >
                      <template v-slot:no-option>
                        <q-item>
                          <q-item-section class="text-grey">Sin registros</q-item-section>
                        </q-item>
                      </template>
                    </q-select>


                  </div>

      </div>
      <br>
      <div class="row justify-center">
          <q-btn color="primary" size="md" label="Registrame" type="submit"/>
      </div>
   </q-form>
  </div>
</template>

<script>



import { errorCheckMsjMixin } from "../../mixins/errorCheckMsjMixin";
import { required, minValue, between, helpers, requiredIf,sameAs,minLength,email } from "vuelidate/lib/validators";
import {notifyMixin} from "../../mixins/notifyMixin";
import { date } from 'quasar'
import axios from 'axios';
//import VueRecaptcha from 'vue-recaptcha';

import Vuex from "vuex"; //importando vuex;

const moneyValidation = helpers.regex(
  "alpha",
  /^\$?([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/
);


export default {
  components:{
        //VueRecaptcha
      },
  name: "Proyecto",
  mixins: [errorCheckMsjMixin, notifyMixin],
  data() {
    return {
    

      
      /*Datos del formulario*/
  
      nombres:null,
      apellidos:null,
      correo:null,
      correoConfirme:null,
      password:null,
      telefono:null,
      isPwd: true,
      isPwd1: true,
      rePassword:null,
      mensaje:null,
      rol:null,
      rolOptions:[
        { id:1, nombre:'Administrador'     },
        { id:2, nombre:'Usuario Final'     }
      ]
  
    };
  },
  validations() {
    
      return {
      
        nombres:{
          required
        },
        apellidos:{
          required
        },
        correo:{
          required,
          email,
        },
        correoConfirme:{
          required,
          sameAsEmail:sameAs('correo'),
          email
          
        },
        password:{
          required,
          minLength: minLength(6)
        },
        rePassword:{
          required,
          sameAsPassword: sameAs('password')
        },
        rol:{
          required
        }

      };
    
  },
  mounted() {
    // this.validar_cliente()
    // this.es_verificar(this.$store.state.update_id.update.id_participacion)
  },
  methods: {

  async  submit(){
        this.$v.$touch();
        if (this.$v.$invalid) {
          this.mostrar_alerta('Por favor verifique la información que ha digitado.',3);
          return;
        } else{
          var params=this.prepararData();

          try {
          const response = await axios.post(process.env.API_URL +
                `users`,params);
            if (response.status === 200) {
             if(response.data.res==true){
               this.mensaje='Su información se registró exitosamente. Los datos para iniciar sesión son su correo electrónico y la contraseña que digitó.'
               await this.$emit('mensaje',this.mensaje);
               this.$emit('close-modal');
             }
              /*this.limpiarForm();
              this.mostrarHistoriaalSeguimientoMetas();
              this.data=[]; */
            }
         
        } catch (error) {
            if( error.response.status === 500 ){
             this.mostrar_alerta('No hay conexión con el Servidor. Por favor contacte al administrador.',3);    
            }
        }
        }
    },
     prepararData(){
      var detalle=[];
      var item={};
      var i;
      var periodo;

      item={
        name:this.nombres + ' ' + this.apellidos,
        password:this.password,
        email: this.correo,
        usu_id_rol:this.rol
  
      }


      return item;
    },

  async  verificarInformacion(opc=null){
      if(opc!=null){
       var params=null;
       var valido=false;
         if(opc==3){
           valido=true;
           params = {
            email: this.correo,
          };
        }
      
      if(valido==true && this.correo!=null){
       try {
          const response = await axios.post(process.env.API_URL +
                `validaremail`,params);
            if (response.status === 200) {
                 if(response.data.length>0 && opc==3){
                  this.mostrar_alerta('El correo eléctronico ya se encuentra registrado.',3);   
                  this.correo=null;   
                }
            }
         
        } catch (error) {
            if( error.response.status === 500 ){
             this.mostrar_alerta('No hay conexión con el Servidor. Por favor contacte al administrador.',3);    
            }
        }
      }

       
      }

    },

    //funcion que obliga al input solo numero, comas y punto
      isNumber: function (evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46 && charCode !== 44) {
          evt.preventDefault();;
        } else {
          return true;
        }
      },

      onVerify: function (response) {
      if (response) this.robot = true;
    },

    validarDUI(){
      return false;
    }
      
  },
  beforeMount() {
    // this.nombrePagina('DISTRIBUCION ZAPATOS ESCOLARES')
    // this.llenar_campos()
  }
};
</script>




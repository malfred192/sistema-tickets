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
          <q-input :dense="true" filled v-model="nit" type="text" label="NIT *" 
            @blur="$v.nit.$touch"  :error="$v.nit.$error"
            :error-message="`${checkErr('NIT', $v.nit)}`"
            mask="####-######-###-#"
            hint="Formato: ####-######-###-#"
            unmasked-value
            @change="verificarInformacion(1)" />
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="dui" label="DUI *" type="text"
            @keypress="isNumber($event)" @blur="$v.dui.$touch" 
            :error="$v.dui.$error" :error-message="`${checkErr('DUI', $v.dui)}`"
            mask="########-#"
            hint="Formato: ########-#"
            unmasked-value 
            @change="verificarInformacion(2)"/>
        </div>
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
          <q-input :dense="true" filled v-model="telefono" label="Teléfono *" type="text"
            @keypress="isNumber($event)" 
            mask="#### - ####"
            hint="Formato: #### - ####"
            unmasked-value 
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

      </div>
      <div class="row justify-center">
        <vue-recaptcha @verify="onVerify" sitekey="6LfYQdgZAAAAAGHrc9tzVShujaCUS1OV5xfbAahE" :loadRecaptchaScript="true"></vue-recaptcha>
      </div>
      <br>
      <div class="row justify-center">
          <q-btn color="primary" size="md" label="Registrame" type="submit"/>
      </div>
   </q-form>
  </div>
</template>
<script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
</script>
<script>

function DUIvalido(dui=null){
  //funcion que valida NIT
  if(dui!=null){
    var digits = dui.substr(0,8),
        dig_ve = parseInt(dui.substr(8,1)),
        sum    = 0;

    // sumar producto de posiciones y digitos
    for(var i = 0, l = digits.length; i < l; i++){
      var d = parseInt(digits[i], 10);
      sum += ( 9 - i ) * d;
    }
    return (dig_ve === (10 - ( sum % 10 ))%10);
  }else{
    return false
  }
}

function NITvalido(nit=null){
  if(nit!=null){
    var ls_dvnit;
    var ls_valor;
    var ls_posi14;
    var li_sum=0;
    var li_factor=0;
    var li_pos=0;
    var li_residuo=0;
    var li_digver=0;
    
    var lvalido=false;
    var lnit=nit; // eliminando los guienes si vienen
    var n;
    
    ls_valor=lnit.substr(0,13);
    ls_posi14=lnit.substr(13);

    if((ls_valor.substr(10,3))<=100) {
      
      n = 1;//Variable contadora 
      for (li_pos =0 ; li_pos <13; li_pos++) { 
        li_sum = li_sum + Number(ls_valor.charAt(li_pos)) * (15 - n);	
        n=n+1;	
      }
      
        li_digver = li_sum  % 11
    
        if( li_digver == 10 ) {
          li_digver = 0
        }
    }else{		
      n = 1;//Variable contadora 
      for (li_pos = 0; li_pos <13; li_pos++) { 
          li_factor = (3 + 6 *  Math.floor((n + 4) / 6)) - n;
          li_sum = li_sum +  Number(ls_valor.charAt(li_pos)) * li_factor; 
          n=n+1;			  
      }
      
      li_residuo = li_sum % 11
      
      if(li_residuo>1) {
          li_digver = 11 - li_residuo
      }else { 
        li_digver = 0
      }
    } // fin del if

    if(ls_posi14==li_digver) {
      lvalido=true;
    }else
    {
      lvalido=false;
    }
    
    return lvalido;
  }else{
    return false;
  }
}


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

const validarDUI = (value) => DUIvalido(value);
const validarNIT = (value) => NITvalido(value);

export default {
  components:{
        //VueRecaptcha
      },
  name: "Proyecto",
  mixins: [errorCheckMsjMixin, notifyMixin],
  data() {
    return {
    

      /*Variable del catcha*/
      robot:false,
      
      /*Datos del formulario*/
      nit:null,
      dui:null,
      nombres:null,
      apellidos:null,
      correo:null,
      correoConfirme:null,
      password:null,
      telefono:null,
      tipoRegistro:8, // es el id actual para el rol de cliente 07/12/2020
      catcha:null,
      isPwd: true,
      isPwd1: true,
      rePassword:null,
      mensaje:null,
  
    };
  },
  validations() {
    
      return {
        nit:{
          required,
          minLength: minLength(14),
         // validarNIT,
        },
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
        dui:{
          required,
          minLength: minLength(9),
        //  validarDUI,
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
        } else if (this.robot==false) {
          this.mostrar_alerta('Por favor marque la casilla del reCAPTCHA.',3);
        }else{
          var params=this.prepararData();

          try {
          const response = await axios.post(process.env.API_URL +
                `login`,params);
            if (response.status === 200) {
             if(response.data.estado==1){
               this.mensaje='Su información se registró exitosamente. Los datos para iniciar sesión son su Número de Identificación Tributaria (NIT) y la contraseña que digitó.'
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
        nombre_usuario: this.nit,
        login: this.nit,
        nombres:this.nombres,
        apellidos:this.apellidos,
        clave:this.password,
        email: this.correo,
        rol:this.tipoRegistro
  
      }

    
      const params={
        usuario:item,
        rol:{
          rol_id:this.tipoRegistro
        }
      }

      return params;
    },

  async  verificarInformacion(opc=null){
      if(opc!=null){
       var params=null;
       var valido=false;
        if(opc==1){
           valido=NITvalido(this.nit);
           params = {
            nit:this.nit.toString()
          };
        }else if(opc==2){
           valido=DUIvalido(this.dui);
           params = {
            dui:this.dui.toString()
          };
        }else if(opc==3){
           valido=true;
           params = {
            email: this.correo,
          };
        }
      
      if(valido==true){
       try {
          const response = await axios.get(process.env.API_URL +
                `login/verificarinformacion`,{params});
            if (response.status === 200) {
                if(response.data.estado==1 && opc==1){
                  this.mostrar_alerta('El número de NIT ya se encuentra registrado.',3);
                  this.nit=null;
                }
                else if(response.data.estado==1 && opc==2){
                  this.mostrar_alerta('El número de DUI ya se encuentra registrado.',3);
                  this.dui=null;
                } else if(response.data.estado==1 && opc==3){
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




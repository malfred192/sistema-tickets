<template>
  <div class="q-gutter-md q-pt-lg">
    <q-form  class="q-gutter-md" @submit.prevent="submit"  autofocus>
      <div class="row flex text-center justify-center">
        <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
        <!--  <img
            alt="Conamype"
            src="~assets/logo_conamype.png"
            v-bind:style="$q.screen.lt.sm?{'width': '40%'}:{'width':'50%'}"
          > -->
        </div>
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
          <strong>Estimado usuario, por favor digite su correo electrónico</strong>
        </div>
      </div>
      <div class="row flex justify-center">
        <div class="col-md-10 col-sm-12 col-xs-12 q-pa-xs">
          <q-input :dense="true" filled v-model="correo" label="Correo Electrónico *" type="email"
            @blur="$v.correo.$touch" 
            :error="$v.correo.$error" :error-message="`${checkErr('Correo Electrónico', $v.correo)}`" 
            />
        </div>
      </div>
     
      <div class="row justify-center">
          <q-btn color="primary" size="md" label="Recuperar Contraseña" type="submit"/>
      </div>
   </q-form>
  </div>
</template>

<script>



import { errorCheckMsjMixin } from "../../mixins/errorCheckMsjMixin";
import { required, minValue, between, helpers, requiredIf,sameAs,minLength,email } from "vuelidate/lib/validators";
import {notifyMixin} from "../../mixins/notifyMixin";
import axios from 'axios';

import Vuex from "vuex"; //importando vuex;

export default {
  components:{

      },
  name: "Proyecto",
  mixins: [errorCheckMsjMixin, notifyMixin],
  data() {
    return {
      correo:null,
      estado:false,
      mensaje:null,
    };
  },
  validations() {
      return {
        correo:{
          required,
          email,
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
        if (!this.$v.$invalid) {
          let params= { email:this.correo };

          try {
          const response = await axios.get(process.env.API_URL +
                `login/resetpassword`,{params});
                console.log(response)
            if (response.status === 200) {
              if(response.data.estado==1)
                this.mensaje='Se ha enviado un correo electrónico a la dirección que proporcionó para que pueda continuar con el proceso de recuperación de contraseña.'
              else
                this.mensaje='La dirección de correo electrónico que proporcionó no se encuetra registrada en nuestro sistema.'


               this.$emit('mensaje',this.mensaje);
               this.$emit('close-modal');
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


      
  },
  beforeMount() {
    // this.nombrePagina('DISTRIBUCION ZAPATOS ESCOLARES')
    // this.llenar_campos()
  }
};
</script>




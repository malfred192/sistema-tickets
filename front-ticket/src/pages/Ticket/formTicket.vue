<template>
  <div class="q-pa-md no-shadow">
    <q-form ref="ticketForm" enctype="multipart/form-data" @submit.prevent="submit" @reset="limpiarForm"  autofocus>
      <div class="q-pa-md">
        <div class="q-gutter-y-md">
          <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs" v-if="idTicket!=null">
            <p class="text-h4 text-center text-weight-bold">Ticket # {{idTicket}}</p>
          </div>
          <q-card>
              <q-tabs
                v-model="tab"
                dense
                active-color="white"
                indicator-color="white"
                align="justify"
                class="bg-accent text-white shadow-5"
                narrow-indicator
                no-caps
                inline-label
              >
                <!-- Nombre de los Tabs -->
                <q-tab name="formTicket" label="Formulario Ticket" @click="tabState = true;" />
                <!-- Fin Nombre de los Tabs -->
              </q-tabs>
              <q-separator />

              <!-- Tabs -->
              <q-tab-panels v-model="tab" animated align="center">
                <q-tab-panel name="formTicket"  class="q-pa-md">
                  <div class="row justify-center">
                    
                  <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                    <br><br>
                      <q-input :dense="true" filled v-model="titulo" type="text" label="Título *"
                        @blur="$v.titulo.$touch"  :error="$v.titulo.$error"
                        :error-message="`${checkErr('Título', $v.titulo)}`"
                        :readonly="es_ver"
                        />
                    </div>
                  </div>

                  <div class="row justify-center">
                    <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                      <q-input :dense="true" filled v-model="descripcion" type="textarea" label="Descripción"
                        :readonly="es_ver" 
                        />
                    </div>
                  </div>
                  <br>
                  <div class="row justify-center">
                    <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                      <q-select :dense="true" filled v-model="prioridad" 
                        label="Nivel de Prioridad *" :options="optionsPrioridad"
                        option-value="nip_id"
                        option-label="nip_nombre"
                        option-disable="inactive"
                        emit-value
                        map-options
                        clearable
                        :readonly="es_ver"
                        @blur="$v.prioridad.$touch"
                        :error="$v.prioridad.$error" :error-message="`${checkErr('Nivel de Prioridad', $v.prioridad)}`">
                        <template v-slot:no-option>
                          <q-item>
                            <q-item-section class="text-grey">No se encontraron registros</q-item-section>
                          </q-item>
                        </template>
                      </q-select>
                    </div>
                  </div>
                    <br>
                <div class="row justify-center" v-if="es_ver==false">      
                    <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                      <q-uploader
                      label="Anexos.Formatos permitidos: pdf, excel, word, png, jpg. "
                      color="primary"
                      :max-file-size="20000000"
                      square
                      flat
                      multiple
                      style="max-width: 1200px"
                      @added="file_model_method"
                      @rejected="onRejected"
                      bordered
                    />
                    </div> 
                  </div> 
                
                 <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs" v-if="es_ver==true">
                  <q-table
                    v-if="es_ver==true"
                    class="my-sticky-virtscroll-table"
                    virtual-scroll
                    :pagination.sync="pagination"
                    :rows-per-page-options="[0]"
                    :virtual-scroll-sticky-size-start="48"
                    row-key="index"
                    :data="data"
                    :columns="columns"

                  >
                  <!-- Modificando slot del body para agregar iconos -->
                        <q-tr slot="body" slot-scope="props" :props="props">
                          <q-td v-for="col in props.cols" :key="col.name" :props="props" :style="{'width': ancho +'px', 'whiteSpace': 'normal'}"  >
                            <div v-if="col.name == 'acciones'" >
                              <q-btn 
                                            flat
                                            round
                                            icon="fas fa-eye"
                                            size="sm"
                                            color="info"
                                            @click="verAnexo(props.row.ant_ruta)"
                                          >
                                <q-tooltip>Ver Anexo: {{props.row.ant_id}}</q-tooltip>
                              </q-btn>
                            </div>
                            <div v-else-if="col.name == 'ant_fecha_creacion'" >
                              {{formatearfecha(col.value)}}
                            </div>
                            <div v-else>{{ col.value }}</div>
                          </q-td>
                        </q-tr>
                        <!-- Fin Modificando slot del body para agregar iconos -->
                  </q-table>
                </div>

                <!--  <div class="row justify-center">      
                    <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
                      <q-file
                        v-model="files"
                        label="Pick files"
                        filled
                        multiple
                        style="max-width: 300px"
                      />
                    </div>
                  </div> -->
                  <br><br>
                  <div class="row justify-center" align="right">
                    <div class="col-md-6 col-sm-8 col-xs-8 q-pa-md" >
                        <div align="center" class="q-gutter-md">
                          <q-btn label="Guardar" type="submit" color="primary" icon="fas fa-save" v-if="idTicket==null" @click="redireccion=1" :disabled="es_ver"/>
                        <!--  <q-btn label="Guardar y volver a la lista" type="submit" color="primary" icon="fas fa-save" v-if="idTicket==null" @click="redireccion=1" :disabled="es_ver"/> -->
                         <!-- <q-btn label="Modificar" type="submit" color="primary" icon="fas fa-save" v-if="idTicket!=null"  @click="redireccion=0" :disabled="es_ver"/> -->
                         <!-- <q-btn label="Modificar y volver a la lista" type="submit" color="primary" icon="fas fa-save" v-if="idTicket!=null" @click="redireccion=1" :disabled="es_ver"/> -->
                          <q-btn label="Regresar" type="buttom" color="primary" icon="arrow_back" @click="regresar" v-if="es_ver"   outline/>
                          <q-btn label="Cancelar" type="buttom" color="primary" icon="cancel" @click="salir" v-if="!es_ver"   outline/>
                          <q-btn label="Limpiar" color="primary"   @click="limpiarForm" outline v-if="!es_ver"/>
                        </div>
                      </div>
                  </div>
                </q-tab-panel>
              </q-tab-panels>
          </q-card>
        </div>
      </div>


    </q-form>
   
  </div>
</template>

<script>
import { errorCheckMsjMixin } from "../../mixins/errorCheckMsjMixin";
import { required, minValue, between, helpers, requiredIf } from "vuelidate/lib/validators";
import {notifyMixin} from "../../mixins/notifyMixin";
import { SessionStorage  } from 'quasar'


import moment from 'moment';
import axios from 'axios';
import Vuex from 'vuex';

const moneyValidation = helpers.regex(
  "alpha",
  /^\$?([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/
);
export default {
  name: "formTickets",
  output: null,
  mixins: [errorCheckMsjMixin, notifyMixin],
  props: ['tic_id','flagLectura'],
  data() {
    return {
      tab: "formTicket",
      idTicket:null, //identificador del ticket
      titulo:null,      //Título del ticket       
      descripcion:null, //Descripción del ticket
      prioridad:null,  //Nivel de prioridad del ticket
      optionsPrioridad:null, //Array que almacena los niveles de prioridad para los tickets
      file_model:[], //objeto que almacena la información de los archivos adjuntos
      es_ver:false, //bandera para saber si el usuario esta consultando el ticket. Si es true los campos del formulario serán disabled
      redireccion:false, //Bandera para saber si se va aredireccionar luego de almacenar/modificar el registro.
      files:[], //Se almacenan los archivos adjuntos al tickets
      data:[], 

       pagination: {
        rowsPerPage: 0
      },

      columns: [
        { name: 'ant_nombre', align: 'center', label: 'Nombre del Anexo', field: 'ant_nombre', sortable: true },
        { name: 'ant_fecha_creacion', align: 'center', label: 'Fecha de registro', field: 'ant_fecha_creacion', sortable: true },
        { name: 'acciones',  align: 'center', label: 'Acciones', field: 'acciones', sortable: true }
      ],



     
     
    };
  },
  validations() {
    return {
        titulo:{
          required
        },
        prioridad:{
          required
        },
    };
  },

  
  methods:{

  /**
   * Metodo que asigna a la variable file_model la información de los documentos adjuntos en el formulario
   * @param file
   * @return none.
   * @author Manuel Hernández
   * @since 2021-04-10
   */
    file_model_method(file){
      this.file_model = file;
     },


   /**
   * Metodo filtra los tipos de documentos adjuntos permitidos
   * @param file
   * @return none.
   * @author Manuel Hernández
   * @since 2021-04-10
   */ 
    checkFileType(files) {
      return files.filter(
        file =>
          file.type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||
          file.type === "application/pdf" ||
          file.type === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ||
          file.type === "application/msword" ||
          file.type === "image/jpeg" ||
          file.type === "application/vnd.ms-excel" 
      );
    },


  /**
   * Metodo que emite alerta si se han adjuntado archivos no validos
   * @param file
   * @return none.
   * @author Manuel Hernández
   * @since 2021-04-10
   */ 
    onRejected(rejectedEntries) {
      this.mostrar_alerta('El formato de archivo no es válido.',3)
    },


    salir(){
      this.$q
        .dialog({
          title: "Salir de Formulario Tickets",
          message: "¿Esta seguro que desea salir? La informción del formulario no se almacenará.",
          cancel: true,
          position: "top",
          ok: {
            push: true,
            color: "negative"
          }
        })
        .onOk(() => {
          this.$router.push('/ticket') 
        }); //Fin de la opcion OK
    },

    regresar(){
      this.$router.push('/ticket');
    },

    /*Formatea la fecha de fotmato UTC a DD/MM/YYYY*/
    formatearfecha(fecha){
      return moment(fecha).utc().format("DD/MM/YYYY").toString();
     
    },

    
    limpiarForm(){
      this.titulo=null,         
      this.descripcion=null, 
      this.prioridad=null, 
      this.file_model=[],
      this.$refs.uploader.reset();
    },

    submit(){
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.mostrar_alerta('Por favor verifique la información del formulario.',3);
        return;
      }else{
        if (this.idTicket === null) {
          this.nuevoTicket();
        } else {
          this.editarSeguimiento();
        }
      }

    },

   async nuevoTicket(){
      var params=this.prepararData();

      try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.post(process.env.API_URL + `ticket`,params);
        if (json.status === 200) {
              console.log(json.data);
              this.mostrar_alerta('Registro Almacenado exitosamente');
              if(this.redireccion==1){
                   this.$router.push('/ticket') 
              }else{
                this.idTicket=json.data.tic_id;
              }
            }
     } catch (error) {
       console.log(error);
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }
      
    },

    prepararData(){

      const formData = new FormData();
      formData.append('tic_nombre',this.titulo);
      formData.append('tic_descripcion', this.descripcion);
      formData.append('tic_id_nip',this.prioridad);
      

      for(let i=0; i<this.file_model.length; i++){
        formData.append('files['+i+']', this.file_model[i])
      }
      return formData;
     },
     
  async   verAnexo(file=null){

    var params={
      file:file
    }

    try{

      let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        const file = await axios.post(process.env.API_URL+`getfile`, params);
        console.log(file);
        //this.optionsPrioridad=json.data;
     } catch (error) {
       console.log(error);
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }
     }
  },
 async mounted(){

   /*Obteniendo las prioridades de los tickets*/
    try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.get(process.env.API_URL + `nprioridad`);
        this.optionsPrioridad=json.data;
     } catch (error) {
       console.log(error);
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }


    
    /*si tic_id es != null entonces habilitaremos la opcion de consultar
    Obteniendo la informacion del ticket*/
  if(this.tic_id!=null){
     try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.get(process.env.API_URL+`ticket/`+this.tic_id);
        if (json.status === 200) {
           this.idTicket=this.tic_id;
           this.titulo=json.data.info.tic_nombre;
           this.descripcion=json.data.info.tic_descripcion,
           this.prioridad=json.data.info.tic_id_nip;
           this.data=json.data.files;
           this.es_ver=true;
       }
     } catch (error) {
       console.log(error);
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }

  }


  },
  computed: {
    ancho(){
      return
        '400' 
        
    },
    //Vuex
      ...Vuex.mapState(['namePage']),
      ...Vuex.mapState("auth", ["usuario"]),
  },

}
</script>

<template>
  <div class="q-pa-md">
    <q-form class="q-gutter-md" autofocus ref="myForm" @submit.prevent="submit">
    <div class="row flex">
      <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
        <strong>Criterios de busqueda</strong>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 q-pa-xs">
        <q-input :dense="true" filled v-model="titulo" type="text" label="Nombre Ticket"  />
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 q-pa-xs">

         <q-select :dense="true" filled v-model="prioridad" 
                        label="Nivel Prioridad" :options=optionsPrioridad
                        option-value="nip_id"
                        option-label="nip_nombre"
                        option-disable="inactive"
                        emit-value
                        map-options
                        clearable
                        >
                        <template v-slot:no-option>
                            <q-item>
                            <q-item-section class="text-grey">No se encontraron registros</q-item-section>
                            </q-item>
                        </template>
                    </q-select>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 q-pa-xs">
         <q-select :dense="true" filled v-model="estado" 
                        label="Estado" :options=optionsEstado
                        option-value="est_id"
                        option-label="est_nombre"
                        option-disable="inactive"
                        emit-value
                        map-options
                        clearable
                        >
                        <template v-slot:no-option>
                            <q-item>
                            <q-item-section class="text-grey">No se encontraron registros</q-item-section>
                            </q-item>
                        </template>
                    </q-select>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
         <q-input filled v-model="fecha_inicio" :rules="['fecha_inicio']" label="Fecha desde" 
          dense  
          clearable 
          mask="##/##/####"
          hint="DD/MM/YYYY"
            >
              <template v-slot:append>
                  <q-icon name="event" class="cursor-pointer">
                  <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                      <q-date v-model="fecha_inicio" @input="() =>validarFechas()" mask="DD-MM-YYYY"/>
                  </q-popup-proxy>
                  </q-icon>
              </template>
          </q-input>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
        <q-input filled v-model="fecha_fin" :rules="['fecha_fin']" label="Fecha hasta" dense clearable 
        @blur="$v.fecha_fin.$touch"  :error="$v.fecha_fin.$error"
          :error-message="`${checkErr('Fecha Fin', $v.fecha_fin)}`">
            <template v-slot:append>
                <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy ref="qDateProxy2" transition-show="scale" transition-hide="scale">
                    <q-date v-model="fecha_fin" @input="() =>validarFechas()" mask="DD/MM/YYYY"/>
                </q-popup-proxy>
                </q-icon>
            </template>
        </q-input>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
         <div align="right" class="q-gutter-md">
          <q-btn label="Buscar Tickets" type="submit" color="secondary" icon="fas fa-search" />
        </div>
      </div>
    </div>
    <br>
    <div class="row flex">
       <div class="col-md-6 col-sm-12 col-xs-12 q-pa-xs">
         <div align="left" class="q-gutter-md">
          <q-btn label="Nuevo Ticket" color="primary" icon="post_add" @click="nuevoTicket()" />
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
        <q-table
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
                                  @click="verTicket(props.row.tic_id)"
                                >
                      <q-tooltip>Ver Ticket: {{props.row.tic_id}}</q-tooltip>
                    </q-btn>
                    <q-btn 
                                  flat
                                  round
                                  icon="event"
                                  size="sm"
                                  color="secondary"
                                  @click="logTicket(props.row.tic_id)"
                                >
                      <q-tooltip>Historial Ticket: {{props.row.tic_id}}</q-tooltip>
                    </q-btn>
                  </div>
                  <div v-else-if="col.name == 'est_nombre'" >
                    {{mostrar_estado(col.value)}}
                  </div>
                  <div v-else-if="col.name == 'tic_fecha_creacion'" >
                    {{formatearfecha(col.value)}}
                  </div>
                  <div v-else>{{ col.value }}</div>
                </q-td>
              </q-tr>
              <!-- Fin Modificando slot del body para agregar iconos -->
        </q-table>
      </div>
    </div>
    </q-form> 
        <q-dialog v-model="modal_log" persistent>
      <q-card style="width: 900px; max-width: 70vw">
        <q-bar dark class="bg-primary text-white">
          <div class="col text-center text-weight-bold">
            <div>Historial de Tickets</div>
          </div>
          <q-space />
          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip>Cerrar</q-tooltip>
          </q-btn>
        </q-bar>

        <!-- Formulario importado -->
        <q-card-section>
          <div class="row justify-center">
              <div class="q-pa-md">
                
                    <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs text-h5 justify-center">
                      <strong>Tickets N°: {{idTicket}} </strong>
                    </div>
                    
                </div>
        </div>
 
  
        <br>
         <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
        <strong>Historial de Seguimiento</strong>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
        <q-table
          class="my-sticky-virtscroll-table"
          virtual-scroll
          :pagination.sync="pagination"
          :rows-per-page-options="[0]"
          :virtual-scroll-sticky-size-start="48"
          row-key="index"
          :data="dataHistorico"
          :columns="columnsHistorico"

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
                                  @click="verTicket(props.row.tic_id)"
                                >
                      <q-tooltip>Ver Ticket: {{props.row.tic_id}}</q-tooltip>
                    </q-btn>
                    <q-btn 
                                  flat
                                  round
                                  icon="event"
                                  size="sm"
                                  color="secondary"
                                  @click="logTicket(props.row.tic_id)"
                                >
                      <q-tooltip>Historial Ticket: {{props.row.tic_id}}</q-tooltip>
                    </q-btn>
                  </div>
                  <div v-else-if="col.name == 'est_nombre'" >
                    {{mostrar_estado(col.value)}}
                  </div>
                  <div v-else-if="col.name == 'sgt_fecha_registro'" >
                    {{formatearfecha(col.value)}}
                  </div>
                  <div v-else>{{ col.value }}</div>
                </q-td>
              </q-tr>
              <!-- Fin Modificando slot del body para agregar iconos -->
        </q-table>
      </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import Vuex from 'vuex';
import moment from 'moment';
import axios from 'axios';
import { errorCheckMsjMixin } from "../../mixins/errorCheckMsjMixin";
import {notifyMixin} from "../../mixins/notifyMixin";
import { loadingScreenMixin } from "../../mixins/loadingScreenMixin";
import { SessionStorage  } from 'quasar'


import {
  required,
  minValue,
  between,
  helpers,
  email,
  requiredIf,
} from "vuelidate/lib/validators";


export default {
  // name: 'PageName',
  mixins: [loadingScreenMixin,notifyMixin, errorCheckMsjMixin],
  
  data(){
    return{
      data:[],
      dataHistorico:[],
      fecha_inicio:'',
      fecha_fin:'',
      titulo:null,
      prioridad:null,
      optionsPrioridad:null,
      estado:'',
      optionsEstado:null,
      modal_log:false,
      idTicket:null,


      pagination: {
        rowsPerPage: 0
      },

      columns: [
        { name: 'tic_id', align: 'center', label: 'Número Ticket', field: 'tic_id', sortable: true },
        { name: 'tic_nombre', align: 'center', label: 'Nombre del Ticket', field: 'tic_nombre', sortable: true },
        { name: 'tic_descripcion', align: 'center', label: 'Descripción', field: 'tic_descripcion', sortable: true },
        { name: 'tic_fecha_creacion', align: 'center', label: 'Fecha de Registro', field: 'tic_fecha_creacion', sortable: true },
        { name: 'nip_nombre',  align: 'center', label: 'Prioridad', field: 'nip_nombre', sortable: true },
        { name: 'est_nombre', align: 'center', label: 'Estado', field: 'est_nombre', sortable: true },
        { name: 'acciones',  align: 'center', label: 'Acciones', field: 'acciones', sortable: true }
      ],

      columnsHistorico: [
        { name: 'sgt_fecha_registro', align: 'center', label: 'Fecha', field: 'sgt_fecha_registro', sortable: true },
        { name: 'name', align: 'center', label: 'Usuario', field: 'name', sortable: true },
        { name: 'est_nombre', align: 'center', label: 'Estado', field: 'est_nombre', sortable: true },
        { name: 'sgt_comentario',  align: 'center', label: 'Comentario', field: 'sgt_comentario', sortable: true },
      ],


    };
    
  },
  validations() {
        return {
            fecha_fin:{
              required: requiredIf(function () {
                return this.fecha_inicio!=''
              })
            },
        };
    },
  methods:{
    //Vuex
    ...Vuex.mapMutations(['nombrePagina']),

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

    
  async  submit(event){
      this.$v.$touch();
        if (this.$v.$invalid) {
          this.mostrar_alerta('Por favor verifique la información que ha digitado.',3);
          return;
        }
      var f1;
      var f2;
        if(this.fecha_inicio!='' && this.fecha_fin!=''){
          f1=moment(this.fecha_inicio,'DD/MM/YYYY').format('YYYY-MM-DD');
          f2=moment(this.fecha_fin,'DD/MM/YYYY').format('YYYY-MM-DD');

          if(f2<f1){
            this.fecha_inicio='';
            this.fecha_fin='';
            this.mostrar_alerta('Rangos de fechas incorrectos. Por favor vuelva a ingresarlo', 3);
            return;
          }
         
        }

          const params = {
            titulo:this.titulo, //publicados
           fecha_inicio:(this.fecha_inicio!='')?moment(this.fecha_inicio,'DD/MM/YYYY').format('YYYY-MM-DD'):null,
           fecha_fin:(this.fecha_fin!='')?moment(this.fecha_fin,'DD/MM/YYYY').format('YYYY-MM-DD'):null,
            prioridad:this.prioridad,
            estado:this.estado
          };

         
          


           /*Consultamos los registros del usuario logueado*/
          try {
              let token= this.$store.state.auth.access_token;
              if(token==null){
                token=SessionStorage.getItem("key");
              }

              this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
              const json = await axios.get(process.env.API_URL + `buscar_registros`,{params});
              this.data=json.data;
          } catch (error) {
            console.log(error);
            if (error.response.status === 401) {
                this.$router.push("/Login");
            }
          }
    },


    /*Formatea la fecha de fotmato UTC a DD/MM/YYYY*/
    formatearfecha(fecha){
      return moment(fecha).utc().format("DD/MM/YYYY").toString();
     
    },


    /*Editar un tickets*/
    verTicket(id){
     this.$router.push({
              name:'administrarTicket',
              params:{tic_id :  id, flagLectura:true}
            });
  },

  /*Carga el formulario para registro de tickets*/
   nuevoTicket(){
     this.$router.push({
              name:'administrarTicket',
              params:{tic_id :  null, flagLectura:false}
            });
  },

  /*Valida un rango de fecha*/
  validarFechas(){
      var a = null;
      var b = null;
      this.$refs.qDateProxy.hide();
      this.$refs.qDateProxy2.hide();

      if(this.fecha_fin!=null && this.fecha_inicio==null){
        this.mostrar_alerta('Por favor seleccione Fecha Desde.',3);
      }else if(this.fecha_fin!=null && this.fecha_inicio!=null){ /*Comporbando fechas*/
        a=moment(this.fecha_inicio,'DD-MM-YYYY').format('YYYY-MM-DD');
        b=moment(this.fecha_fin,'DD-MM-YYYY').format('YYYY-MM-DD');
      }

       if(a>b){
         this.mostrar_alerta('Rango de Fecha Incorrecto',3);
         this.fecha_inicio=null;
         this.fecha_fin=null;
       }
    },

    mostrar_estado(valor=null){
        return (valor!=null)?valor:'-';
    },

    /*Carga el historial de los estados de un tickets*/
  async  logTicket(id=null){
      this.modal_log=true;
      this.idTicket=id;

      /*Obteniendo la inforamciuon del tickets seleccionado*/
      try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.get(process.env.API_URL+`historicoticket/`+this.idTicket);
        if (json.status === 200) {
          this.dataHistorico=json.data;
  
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
  
   async mounted() {

     /*Consultamos los registros del usuario logueado*/
    try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.get(process.env.API_URL + `ticket`);
       this.data=json.data;
     } catch (error) {
       console.log(error);
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }

  /*Obtenemos los registros de niveles de priridad*/
     try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.get(process.env.API_URL + `nprioridad`);
        this.optionsPrioridad=json.data;
     } catch (error) {
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }


     /*Obtenemos los estados registrados para los tickets*/
     try {
       let token= this.$store.state.auth.access_token;
       if(token==null){
         token=SessionStorage.getItem("key");
       }

      this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
       const json = await axios.get(process.env.API_URL + `estado`);
        this.optionsEstado=json.data;
     } catch (error) {
       if (error.response.status === 401) {
           this.$router.push("/Login");
       }
     }
  }


  }
</script>



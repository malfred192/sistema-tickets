export const notifyMixin = {
  data() {
    return {};
  },
  methods: {
    //color para estados del POA
    mostrar_alerta(msg='',tipo=1 ,color='info', icon='fas fa-info-circle',  position= 'top-right', type=null) {
      if(tipo == 1){ //Success
        type= 'positive',
        color='info'
      } else if(tipo == 2){ //Warning
        type= 'warning',
        color='warning'
      } else if (tipo== 3){ //Danger
        type="negative",
        color='negative'
      }

        this.$q.notify({
          type:type,
          message: msg,
          color: color,
          position: position,
          timeout: 10000,
        });
    },

  },
  created() {}
 
};

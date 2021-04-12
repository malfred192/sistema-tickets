<template>
  <q-layout view="hhh lpR lff">
   

    

    <q-page-container>

     
        
     
      <router-view />
      
    </q-page-container>

  
  </q-layout>
</template>

<script>
import Vuex from 'vuex';

export default {
  name: "MyLayout",
  data() {
    return {
      rol: 1,
      left: false,
      dialog: false,
    };
  },
  computed: {
    //Vuex
      ...Vuex.mapState(["namePage"])
  },
  mounted() {
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
            color: "negative",
          },
        })
        .onOk(() => {
          this.$axios
            .get(process.env.API_URL + "usuario/logout")
            .then((response) => {
              this.$store.dispatch("auth/cerrarSesion");
            })
            .catch((error) => {
               if (error.response.data.code === 401) {
                this.$q.notify({
                  message:
                    "No es posible Cerrar Sesión",
                  color: "negative"
                });
              } 
            });
        });
    },
  },
};
</script>
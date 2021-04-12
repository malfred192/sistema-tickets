<template>
  <q-page>
    <div style='background-image: url("../img/inicio2.png");no-repeat center center fixed;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;' class="window-height window-width row justify-center items-center ">
      <div class="column q-pa-md ">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs">
          <q-card square class="shadow-24" style="width:auto;height:400px;">
            <q-card-section>
                    <q-img class="absolute-top" src="~assets/inicio2.png" style="height: 0px"/>
              <q-form class="q-px-sm q-pt-xl">
                <q-input size="lg" square :dense="true" filled v-model="email" type="text" label="Usuario *">
                  <template v-slot:prepend>
                    <q-icon name="users" />
                  </template>
                </q-input>
                <br>
                <q-input square :dense="true" filled v-model="password" type="password" label="Contraseña *">
                  <template v-slot:prepend>
                    <q-icon name="lock" />
                  </template>
                </q-input>
              </q-form>
            </q-card-section>
            <q-card-actions class="q-px-lg">
              <q-btn unelevated size="lg" color="primary" class="full-width text-white" label="Iniciar Sesión" />
            </q-card-actions>
            <q-card-section class="text-center q-pa-sm">
              <p class="text-primary">¿Olvido su contraseña?</p>
              <p class="text-primary">Registrarse</p>
            </q-card-section>
          </q-card>
        </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  name: 'Login',
  data () {
    return {
      email: '',
      username: '',
      password: ''
    }
  }
}
</script>

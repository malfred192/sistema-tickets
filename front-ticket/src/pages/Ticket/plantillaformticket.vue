<template>
  <div class="q-pa-md no-shadow">
    <q-form class="q-gutter-md" @submit.prevent="submit" @reset="onReset"  autofocus>
      <div class="q-pa-md">
        <div class="q-gutter-y-md">
          <div class="col-md-12 col-sm-12 col-xs-12 q-pa-xs" v-if="idConvenio!=null">
            <p class="text-h4 text-center text-weight-bold">Convenio # {{idConvenio}}</p>
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
            <q-tab-panels v-model="tab" animated>
              <q-tab-panel name="formTicket">
                <p>saludemos</p>
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


import moment from 'moment';
import axios from 'axios';
import Vuex from 'vuex';

const moneyValidation = helpers.regex(
  "alpha",
  /^\$?([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/
);
export default {
  name: "Convenio",
  output: null,
  mixins: [errorCheckMsjMixin, notifyMixin],
  props: ['cvn_convenio_id','flagLectura'],
  data() {
    return {
      tab: "formTicket",


     
     
    };
  },
}
</script>

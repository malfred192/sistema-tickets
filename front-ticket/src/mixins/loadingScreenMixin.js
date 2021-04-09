import { QSpinnerOval } from "quasar";
import axios from "axios";

export const loadingScreenMixin = {
  data() {
    return {};
  },
  methods: {
      showLoading() {
      const spinner =
        typeof QSpinnerOval !== "undefined"
          ? QSpinnerOval // Non-UMD, imported above
          : Quasar.components.QSpinnerOval; // eslint-disable-line

      this.$q.loading.show({
        spinner,
        spinnerColor: "primary",
        spinnerSize: 75,
        backgroundColor: "white",
        message: "Espere por favor...",
        messageColor: "black"
      });
    }
  },

  created() {
    axios.interceptors.request.use(
      config => {
        this.showLoading();
        return config;
      },
      error => {
        this.$q.loading.hide();
        return Promise.reject(error);
      }
    );

    axios.interceptors.response.use(
      response => {
        this.$q.loading.hide();
        return response;
      },
      error => {
        this.$q.loading.hide();
        return Promise.reject(error);
      }
    );
  }
};

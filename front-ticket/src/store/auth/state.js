
/**
   * Definicion de las variables de estado del módulo auth
   * @param none
   * @return none.
   * @author Manuel Hernández
   * @since 2021-04-09
   */

export default function () {
  return {
    authenticated: false,

    /* Información del usuario logueado*/
    usuario: {
      email:null,
      name:null,
      rol:null,
      rol_id:null,
      usu_id:null
    },

    /* Token generado por laravel passport para solicitar autorizacion al realizar las peticiones al ws. */
    access_token:null
  }
}

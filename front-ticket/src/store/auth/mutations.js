/**
   * Cambia el valor de la variable de estado que nos indica si la sesión está activa.
   * @param state y stado
   * @return none.
   * @author Manuel Hernández
   * @since 2021-04-13
   */
export function setAuthentication(state, status) {
    state.authenticated = status;

  }
  



  
  /**
   * Asigna valor a las variables definidas en el state, esto para saber quien es usuario logueado
   * @param state y objeto user
   * @return none.
   * @author Manuel Hernández
   * @since 2021-04-13
   */
  export function setUserData(state, user) {
    state.usuario.email = user.user.email;
    state.usuario.name = user.user.name;
    state.usuario.rol = user.user.rol;
    state.usuario.rol_id = user.user.rol_id;
    state.usuario.usu_id = user.user.usu_id;

    state.access_token= user.access_token;
  }

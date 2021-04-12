export function setAuthentication(state, status) {
    state.authenticated = status;

  }
  
  export function setUserData(state, user) {

    state.usuario.email = user.user.email;
    state.usuario.name = user.user.name;
    state.usuario.rol = user.user.rol;
    state.usuario.rol_id = user.user.rol_id;

    state.access_token= user.access_token;

    console.log(state.usuario);
    
  }

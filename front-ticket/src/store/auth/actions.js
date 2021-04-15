/**
 * Permite realizar commit a las mutaciones para asignar valores a las variables definidas en el state
 * @param context y objeto user
 * @return none.
 * @author Manuel Hernández
 * @since 2021-04-10
 */
export function setUser (context, usr) {
    context.commit("setAuthentication", true);
    context.commit("setUserData", {
      user: usr.usu,
      access_token:usr.access_token,
    });
}


/**
 * Cierre de sesión de usuario. Asigna valores por defecto a los state.
 * @param context
 * @return none.
 * @author Manuel Hernández
 * @since 2021-04-10
 */
export function cerrarSesion(context) {
    context.commit("setAuthentication", false);
    context.commit("setUserData", {
      user: {
        email:null,
        name:null,
        rol:null,
        rol_id:null,
        usu_id:null
      },
      access_token:null
      });

  }


  /**
 * Consulta la api para verificar que las credenciales de usuario son validas.
 * Posteriormente realiza commit a las mutaciones para asignarle la información
 * del usuario logueado
 * @param state y objeto user
 * @return none.
 * @author Manuel Hernández
 * @since 2021-04-10
 */
   export async function login(context, usuario){
    try {
      const res = await fetch(process.env.API_URL + `login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(usuario)
      })
      const usr = await res.json();
      if(JSON.stringify(usr)!='[]'){
       await context.commit("setAuthentication", true);
      }else{
       await context.commit("setAuthentication", false);
      }
      await context.commit("setUserData", usr); 
    } catch (error) {
      console.log('error: ', error)
    }
  }


  /**
 * Verifica si la informacion del usuario logueado desde el front es válida en el backend
 * Esta funaicón se realizó con el objetivo de que si el usuario abre sesion en pestañs distintas
 * el state del módulo auth no se pierda.
 * @param context
 * @return none.
 * @author Manuel Hernández
 * @since 2021-04-10
 */
  export async function verificarUsuario(context){
    const usr=JSON.parse(sessionStorage.getItem('login'));
    if(JSON.stringify(JSON.parse(sessionStorage.getItem('login')))!='[]' && JSON.stringify(JSON.parse(sessionStorage.getItem('login')))!='null'){
      await context.commit("setAuthentication", true);
      await context.commit("setUserData",usr);
    } else {
      await context.commit("setAuthentication", false);
      await context.commit("setUserData", usr);
    }
  }


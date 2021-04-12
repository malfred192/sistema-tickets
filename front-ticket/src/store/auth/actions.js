export function setUser (context, usr) {
    context.commit("setAuthentication", true);
    context.commit("setUserData", {
      nombres: usr.nombres,
      apellidos: usr.apellidos,
      area: usr.area,
      rol: usr.rol,
      rol_nombre:usr.rol_nombre,
      nit: usr.nit,
      oficina:usr.oficina,
      oficina_id: (isNaN(parseFloat(usr.oficina_id))) ? null : parseFloat(usr.oficina_id)
    });
}

export function cerrarSesion(context) {
    context.commit("setAuthentication", false);
    context.commit("setUserData", {
        email:null,
        name:null,
        rol:null,
        rol_id:null,
      });

  }


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
     // await  sessionStorage.setItem('login', JSON.stringify(usr));
    } catch (error) {
      console.log('error: ', error)
    }
  }


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


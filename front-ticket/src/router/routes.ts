import { RouteConfig } from 'vue-router';
import store from "../store"
import { SessionStorage } from 'quasar'


let rol=SessionStorage.getItem("rol");
let authenticated=SessionStorage.getItem("authenticated");
const routes: RouteConfig[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '',name: "", component: () => import('pages/Index.vue') },
      { 
        path: '/inicio',
        name: "inicio", 
        component: () => import('pages/Index.vue'),
       beforeEnter: (to, from, next) => {
          if (SessionStorage.getItem("authenticated") == false) {
            next("/");
          } else {
            next();
          }
        },
      },

      /* Sección de tickets */
      { 
        path: '/ticket',
        name: "ticket", 
        component: () => import('pages/Ticket/index.vue'),
        beforeEnter: (to, from, next) => {
          if (SessionStorage.getItem("rol") == 3 ) {
            next("/");
          } else {
            next();
          }
        },
      },

      /*Nuevo o editar Tickets*/
      {
        path: "/administrarTicket",
        name: "administrarTicket",
        component: () => import("pages/Ticket/formTicket.vue"),
        props: true,
      },

      /* Gestion de tickets */

      { 
        path: '/gestionarticket',
        name: "gestionarticket", 
        component: () => import('src/pages/Ticket/gestionTicket.vue'),
        beforeEnter: (to, from, next) => {
          if (SessionStorage.getItem("rol") == 2) {
            next("/");
          } else {
            console.log(SessionStorage.getItem("authenticated"));
            next();
          }
        },
      }
      




    ]
  },
  {
    //Registrarse sin el inicio de sesion
    path: "/Login",
    name: "login",
    component: () => import("layouts/Login.vue"),
    children: [
      {
        path: "/Login",
        name: "login",
        component: () => import("pages/Login/Index.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  },
]



export default routes;

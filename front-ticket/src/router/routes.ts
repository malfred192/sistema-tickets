import { RouteConfig } from 'vue-router';
import store from "../store"
import { LocalStorage, SessionStorage } from 'quasar'

let rol=LocalStorage.getItem("rol");
let authenticated=LocalStorage.getItem("authenticated");
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
          if (LocalStorage.getItem("authenticated") == false) {
            next("/");
          } else {
            next();
          }
        },
      },

      /* Sección de tickets */
      { 
        path: '/tickets',
        name: "ticket", 
        component: () => import('pages/Ticket/index.vue'),
        beforeEnter: (to, from, next) => {
          if (LocalStorage.getItem("rol") == 1 || LocalStorage.getItem("rol") == 2 ) {
            next("/");
          } else {
            next();
          }
        },
      }

      /* Gestion de tickets */

      { 
        path: '/gestionarticket',
        name: "gestionarticket", 
        component: () => import('pages/Ticket/gestionTicket.vue'),
        beforeEnter: (to, from, next) => {
          if (LocalStorage.getItem("rol") == 2) {
            next("/");
          } else {
            console.log(LocalStorage.getItem("authenticated"));
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
      {
        path: "/reset_password/:id",
        name: "reset_password",
        component: () => import("pages/Login/reset_passwordForm.vue"),
      },
      {
        path: "/sesionconamype",
        name: "sesionconamype",
        component: () => import("pages/Login/sesionConamype.vue"),
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

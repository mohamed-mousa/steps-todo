import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";
import Login from "@/views/Login.vue";
import Register from "@/views/Register.vue";
import Projects from "@/views/Projects.vue";
import Tasks from "@/views/Tasks.vue";
import Profile from "@/views/EditProfile.vue";
import store from "@/store";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
    meta: { notRequireAuth: true }
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: { notRequireAuth: true }
  },
  {
    path: "/register",
    name: "register",
    component: Register,
    meta: { notRequireAuth: true }
  },
  {
    path: "/project/tasks/:id",
    name: "tasks",
    component: Tasks,
    meta: { requiresAuth: true }
  },
  {
    path: "/projects",
    name: "projects",
    component: Projects,
    meta: { requiresAuth: true }
  },
  {
    path: "/profile",
    name: "profile",
    component: Profile,
    meta: { requiresAuth: true }
  },
  {
    path: "/:catchAll(.*)",
    redirect: '/',
    meta: { notRequireAuth: true }
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.state.loggedIn) {
      next("/login");
    } else {
      next();
    }
  }
  else if (to.matched.some(record => record.meta.notRequireAuth)) {
    if (!store.state.loggedIn) {
      next();
    } else {
      next("/projects");
    }
  }
  else {
    next();
  }
});

export default router;

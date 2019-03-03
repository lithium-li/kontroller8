import Vue from "vue";
import VueRouter from "vue-router";
import Dashboard from './pages/Dashboard';
import Items from './pages/Items';
import Calendar from './pages/Calendar';

Vue.use(VueRouter);
Vue.component(Dashboard);
Vue.component(Items);
Vue.component(Calendar);


const router = new VueRouter({
    routes: [
        {path: '/', redirect: '/dashboard'},
        {path: '/dashboard', component: Dashboard, name: "dashboard"},
        {path: '/calendar', component: Calendar, name: "calendar"},
        {path: '/items', component: Items, name: "items"}
    ],
    mode: "history",
    linkActiveClass: "mdc-list-item--activated"
});


export default router;
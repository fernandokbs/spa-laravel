import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/Home';
import About from './views/About';
import NotFound from './views/NotFound';
import BookIndex from './views/BookIndex';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '', component: BookIndex },
        { path: '/home', component: Home },
        { path: '/about', component: About },
        { path: '*', component: NotFound }
    ]
});
import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/Home';
import About from './views/About';
import NotFound from './views/NotFound';
import BookIndex from './views/BookIndex';
import MyBooks from './views/MyBooks';
import BookShow from './views/BookShow';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: BookIndex },
        { path: '/home', component: Home },
        { path: '/my_books', component: MyBooks },
        { path: '/about', component: About },
        { path: '/books/:slug', component: BookShow, name: 'show' },
        { path: '*', component: NotFound, name: 'notFound' }
    ]
});
import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/Home';
import About from './views/About';
import NotFound from './views/NotFound';
import ArticleIndex from './views/ArticleIndex';
import MyArticles from './views/MyArticles';
import ArticleShow from './views/ArticleShow';
import ArticleEdit from './views/ArticleEdit';
import ArticleCreate from './views/ArticleCreate';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: ArticleIndex },
        { path: '/home', component: Home },
        { path: '/my_articles', component: MyArticles },
        { path: '/about', component: About },
        { path: '/articles/create', component: ArticleCreate, name: 'create' },
        { path: '/articles/:slug', component: ArticleShow, name: 'show' },
        { path: '/articles/:slug/edit', component: ArticleEdit, name: 'edit' },
        { path: '*', component: NotFound }
    ]
});
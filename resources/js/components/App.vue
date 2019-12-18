<template>
    <div class="h-screen bg-white">
        <nav id="header" class="fixed w-full z-10 top-0 bg-white border-b border-gray-400">
         <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-4">
            <div class="pl-4 flex items-center">
               <svg class="h-5 pr-3 fill-current text-purple-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M0 2C0 .9.9 0 2 0h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm14 12h4V2H2v12h4c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2zM5 9l2-2 2 2 4-4 2 2-6 6-4-4z"/>
               </svg>
               <a class="text-gray-900 text-base no-underline hover:no-underline font-extrabold text-xl" href="/">Articles</a>
            </div>
            <div class="block lg:hidden pr-4">
               <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-purple-500 appearance-none focus:outline-none">
                  <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <title>Menu</title>
                     <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                  </svg>
               </button>
            </div>
            <div class="w-full flex-grow lg:flex  lg:content-center lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 z-20" id="nav-content">
               <div class="flex-1 w-full mx-auto max-w-sm content-center py-4 lg:py-0">
               </div>
               <ul class="list-reset lg:flex justify-end items-center">
                  <li class="mr-3 py-2 lg:py-0">
                     <router-link to="/" class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Home</router-link>
                  </li>
                  <li class="mr-3 py-2 lg:py-0">
                    <router-link to="/my_articles" class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">My Articles</router-link>
                  </li>
                  <li class="mr-3 py-2 lg:py-0">
                     <router-link to="/home" class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Lorem</router-link>
                  </li>
                  <li class="mr-3 py-2 lg:py-0">
                    <router-link to="/about" class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">About</router-link>
                  </li>

                  <li class="mr-3 py-2 lg:py-0">
                    <router-link to="#" v-on:click.native="logout" class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Logout</router-link>
                  </li>
               </ul>
            </div>
         </div>
      </nav>

    <div class="container justify-center w-full flex flex-wrap mx-auto px-2 pt-2 lg:pt-16 mt-2">
         <div class="w-full p-8 mt-6 text-gray-900">
            <router-view></router-view>
         </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        created() {
            window.token = this.user.api_token;
            window.id = this.user.id;

            axios.interceptors.request.use((config) => {
                if(config.method === "get") {
                    let page = '';

                    if (config.url.match(/\?./)) {
                        let url = config.url.split('?');
                        let page = url[1];
                        url = url[0];

                        config.url = `${url}?api_token=${this.user.api_token}&${page}`;
                        return config; 
                    }
                    
                    config.url = `${config.url}?api_token=${this.user.api_token}`;
                }
                else
                    config.data = {
                        api_token: this.user.api_token,
                        ...config.data
                    }
               
                return config;
            });
        },

        methods: {
           logout() {
                axios.post('/logout')
                .catch(error => {
                     window.location.href = '/login';
               });
           }
        }
    }
</script>

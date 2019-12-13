<template>
    <div class="h-screen bg-white">
        <div class="flex">
            <div class="py-6 bg-blue-900 w-48 h-screen border-r-2 border-blue-300 text-lg">
                <router-link to="/" class="text-white flex flex-1 justify-center py-4">Books</router-link>
                <router-link to="/home" class="text-white flex flex-1 justify-center py-4">Home</router-link>
                <router-link to="/about" class="text-white flex flex-1 justify-center py-4">About</router-link>
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <router-view class="p-6"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        created() {
            window.token = this.user.api_token;

            axios.interceptors.request.use((config) => {
                console.log(config);
                if(config.method === "get")
                    config.url = config.url + "?api_token=" + this.user.api_token;
                else
                    config.data = {
                        api_token: this.user.api_token,
                        ...config.data
                    }

                return config;
            });
        }
    }
</script>

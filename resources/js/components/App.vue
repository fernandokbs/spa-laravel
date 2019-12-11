<template>
    <div class="h-screen bg-white">
        <div class="flex">
            <div class="pl-6 bg-blue-900 w-48 h-screen border-r-2 border-blue-300">
                <router-link to="/" class="text-white">Home</router-link>
                <router-link to="/about">About</router-link>
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {}
    }
</script>

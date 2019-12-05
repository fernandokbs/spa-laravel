<template>
    <div>
        <h1>App</h1>
        <router-view></router-view>
        <router-link to="/">Home</router-link>
        <router-link to="/about">About</router-link>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

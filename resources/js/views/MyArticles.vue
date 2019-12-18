<template>
    <div>
        <h1 class="text-center text-6xl font-medium">Personal posts</h1>
        <div class="text-right">
            <button @click="create" class="bg-blue-500 py-4 px-4 text-white rounded">Crear Article</button>
        </div>
        <ArticleList endpoint='/api/my_articles'></ArticleList>
    </div>
</template>

<script>
    import ArticleList from '../components/ArticleList';

    export default {
        data() {
            return {}
        },

        components: {
            ArticleList
        },

        methods: {
            create() {
                this.$router.push({ name: 'create' });
            }
        }
    }
</script>

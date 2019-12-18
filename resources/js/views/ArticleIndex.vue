<template>
    <div>
        <ArticleList endpoint='/api/articles'></ArticleList>
    </div>
</template>

<script>
    import ArticleList from '../components/ArticleList';

    export default {
        data() {
            return { }
        },
        
        components: {
            ArticleList
        },

        created() {
            console.log("Created");
        },
 
    }
</script>

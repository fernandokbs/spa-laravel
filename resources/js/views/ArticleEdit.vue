<template>
    <div>
        <h1 class="text-center text-3xl">Edit Article</h1>
        <ArticleForm action="edit" :article="article"></ArticleForm>
    </div>
</template>

<script>
    import ArticleForm from '../components/ArticleForm';

    export default {
        data() {
            return {
                article: {},
            }
        },

        components: {
            ArticleForm
        },

        created() { 
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get('/api/articles/' + this.$route.params.slug)
                    .then(response => {
                        this.article = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
        }
    }
</script>

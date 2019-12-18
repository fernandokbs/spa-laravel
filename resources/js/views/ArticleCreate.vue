<template>
    <div>
        <h1 class="text-center text-3xl">Create Article</h1>
        <ArticleForm action="create" :article="article"></ArticleForm>
    </div>
</template>

<script>
    import ArticleForm from '../components/ArticleForm';

    export default {
        data() {
            return {
                article: {
                    'attributes' : {
                        'title' : '',
                        'content' : ''
                    }
                }
            }
        },

        components: {
            ArticleForm
        },
    }
</script>

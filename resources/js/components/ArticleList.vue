<template>
    <div>
        <div class="flex flex-wrap justify-center">
            <div @click="show(article.slug)" v-for="article of articles" :key="article.id" class="max-w-sm rounded overflow-hidden shadow-lg mx-4 my-4">
                <img class="w-full" :src="article.attributes.picture" alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ article.attributes.title }}</div>
                    <p class="text-gray-700 text-base">
                        {{ article.attributes.content }} ...
                    </p>
                </div>

                <div class="px-6 py-4">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#photography</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#travel</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#winter</span>
                </div>
            </div>
        </div>

        <ul class="flex justify-center">
            <li v-for="page in pagination.last_page" :key="page"
                class="py-2 px-2 "
            ><button @click="doPagination(page)" class="px-4 py-4 text-white bg-blue-400 rounded">{{ page }}</button></li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                articles: [],
                pagination: {}
            }
        },

        props: ['endpoint'],
        
        created() {
            this.fetchArticles();
        },

        methods: {
            fetchArticles(page = this.endpoint) {
                axios.get(page)
                    .then(response => {
                        this.articles = response.data.data;
                        this.makePagination({ ...response.data.meta, ...response.data.links })
                    }).catch(e => {
                        console.log(e);
                    });
            },
            
            makePagination(data) {
                this.pagination = data;
            },

            doPagination(page) {
                this.fetchArticles(`${this.endpoint}?page=${page}`);
            },

            show(slug) {
                this.$router.push({ name: 'show', params: { slug } });
            }
        },
    }
</script>

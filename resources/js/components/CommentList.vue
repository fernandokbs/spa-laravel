<template>
    <div class="mt-20">
        <h1 class="mb-10">Comments</h1>
        <div v-for="comment of comments" :key="comment.id" class="max-w-sm w-full lg:max-w-full lg:flex px-4 py-4">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center  overflow-hidden" > <img class="h-16 w-16 rounded-full mx-auto" src="https://picsum.photos/250/200">
                <div class="text-center md:text-center">
                    <h2 class="text-lg">{{ comment.relationships.author.name }}</h2>
                </div>
            </div>
            <div class="border-solid border-2 w-full border-gray-400 p-4 flex flex-col justify-between leading-normal">
                {{ comment.attributes.content }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['articleSlug'],
        
        data() {
            return {
                comments: []
            }
        },

        created() {
            this.fetch();
        },

        methods: {
             fetch() {
                 console.log(this.articleSlug);
                 axios.get(`/api/articles/${this.articleSlug}/comments`)
                    .then(response => {
                        this.comments = response.data.data;
                        console.log(this.comments);
                    })
                    .catch(error => {

                    });
             }
        },
    }
</script>

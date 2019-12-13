<template>
    <div class="flex flex-wrap">
        <div v-for="book of books" :key="book.id" class="max-w-sm rounded overflow-hidden shadow-lg">
            <img class="w-full" alt="Sunset in the mountains">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ book.attributes.title }}</div>
                <p class="text-gray-700 text-base">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                </p>
            </div>
            <div class="px-6 py-4">
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#photography</span>
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#travel</span>
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#winter</span>
            </div>
        </div>

        <p v-for="book of books" >{{  }}</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: []
            }
        },
 
        created() {
            this.fetchBooks();
        },

        methods: {
            fetchBooks() {
                axios.get(`/api/books?api_token=${window.token}`)
                    .then(response => {
                        this.books = response.data.data;
                        console.log(this.books);
                    }).catch(e => {
                        console.log(e);
                    });
            }
        }
    }
</script>

<template>
    <div class="text-center">
        <template v-if="book.attributes">
            <div class="font-sans container">
                <div v-if="can()" class="text-right">
                    <button @click="destroy" class="bg-red-500 py-4 px-4 text-white rounded">Eliminar</button>
                    <button @click="edit" class="bg-blue-500 py-4 px-4 text-white rounded">Edit</button>
                </div>
				
                <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">{{ book.attributes.title }}</h1>
				<p class="text-sm md:text-base font-normal text-gray-600">{{ book.attributes.created_at  }}</p>

                <p class="py-6"> {{ book.attributes.content }} </p>
			</div>
        </template>    
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book: {}
            }
        },   
        
        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(`/api/books/${this.$route.params.slug}`)
                    .then(response => {
                        this.book = response.data;
                    })
                    .catch(error => {
                        if (error.response.status === 404)
                            this.$router.push({ name: 'notFound' });
                    });
            },

            can() {
                return this.book.user_id === window.id;
            },

            destroy() {
                axios.delete(`/api/books/${this.book.slug}`)
                    .then(response => {
                        this.$router.push({ path: '/my_books' });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            edit() {
                let slug = this.book.slug;
                this.$router.push({ name: 'edit', params: { slug } });
            }
        },
    }
</script>

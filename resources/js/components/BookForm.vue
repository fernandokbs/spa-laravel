<template>
    <div class="flex justify-center mt-6">
        <template v-if="book.attributes">
            <form @submit.prevent="submitForm" class="w-full max-w-xl">
                <div class="md:flex md:items-center mb-6">
                    <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="text" v-model="book.attributes.title" name="title">
                </div>
                <div class="md:flex md:items-center mb-6">
                    <textarea rows="10" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-username" v-model="book.attributes.content" name="content"></textarea>
                </div>
                <div class="md:flex justify-center">
                    <button class="w-64 shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                        {{ buttonTitle  }}
                    </button>
                </div>
                </form>
        </template>
    </div>
</template>

<script>
    export default {
        props: ['action','book'],
        
        data() {
            return {
                errors: []
            }
        },

        created() {

        },

        methods: {
            submitForm() {
                if(this.action === 'edit')
                    this.updateBook();
                else
                    this.createBook();
            },

            createBook() {
                axios.post('/api/books', this.book.attributes)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            updateBook() {
                axios.put(`/api/books/${this.book.slug}`, this.book.attributes)
                    .then(response => {
                        let slug = response.data.data.slug;
                        this.$router.push({ name: 'show', params: { slug } });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            getErrors(errors) {
                
            }
        },

        computed: {
            buttonTitle() {
                return this.action === 'edit' ? "Update" : "Create"
            }
        }
    }
</script>

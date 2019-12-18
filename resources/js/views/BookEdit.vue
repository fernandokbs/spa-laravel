<template>
    <div>
        <h1 class="text-center text-3xl">Edit book</h1>
        <BookForm action="edit" :book="book"></BookForm>
    </div>
</template>

<script>
    import BookForm from '../components/BookForm';

    export default {
        data() {
            return {
                book: {},
            }
        },

        components: {
            BookForm
        },

        created() { 
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get('/api/books/' + this.$route.params.slug)
                    .then(response => {
                        this.book = response.data;
                        console.log(this.book);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            submit() {
                
            }
        }
    }
</script>

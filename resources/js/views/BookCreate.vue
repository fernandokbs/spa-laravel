<template>
    <div>
        <h1 class="text-center text-3xl">Create Book</h1>
        <BookForm action="create" :book="book"></BookForm>
    </div>
</template>

<script>
    import BookForm from '../components/BookForm';

    export default {
        data() {
            return {
                book: {
                    'attributes' : {
                        'title' : '',
                        'content' : ''
                    }
                }
            }
        },

        components: {
            BookForm
        },
    }
</script>

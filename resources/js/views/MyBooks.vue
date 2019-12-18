<template>
    <div>
        <h1 class="text-center text-6xl font-medium">Personal posts</h1>
        <div class="text-right">
            <button @click="create" class="bg-blue-500 py-4 px-4 text-white rounded">Crear book</button>
        </div>
        <BookList endpoint='/api/my_books'></BookList>
    </div>
</template>

<script>
    import BookList from '../components/BookList';

    export default {
        data() {
            return {}
        },

        components: {
            BookList
        },

        methods: {
            create() {
                this.$router.push({ name: 'create' });
            }
        }
    }
</script>

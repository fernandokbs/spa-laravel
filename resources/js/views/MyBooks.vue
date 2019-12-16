<template>
    <div>
        <h1 class="text-center text-6xl font-medium">Personal posts</h1>
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
        }
    }
</script>

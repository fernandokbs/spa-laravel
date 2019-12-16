<template>
    <div>
        <BookList endpoint='/api/books'></BookList>
    </div>
</template>

<script>
    import BookList from '../components/BookList';

    export default {
        data() {
            return { }
        },
        
        components: {
            BookList
        },

        created() {
            console.log("Created");
        },
 
    }
</script>

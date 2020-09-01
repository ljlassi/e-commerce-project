<template>
    <h2>Processing something maybe</h2>
</template>
<script>
    export default {
        name: "home",
        methods: {
            greet: function (event) {
                // `this` inside methods point to the Vue instance
                alert('Hello ' + this.name + '!')
            }
        }
    }
</script>
<style scoped>
</style>


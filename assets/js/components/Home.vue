<template>
    <div>
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <h2>Featured products</h2>
        <div v-for="product in products">
            <table class="table">
                <tr>
                    <td>Product: {{ product.name }}</td>
                    <td>Product price: {{ product.price }}</td>
                    <td><img :src="'/images/' + product.image_file_name" alt="Image of: " :alt="product.name" class="img-thumbnail"></td>
                    <td><button v-on:click="add_to_cart(product.id)" class="btn btn-primary">Add to cart</button></td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        name: "home",
        data () {
            return {
                products: null,
                controller_response: null
            }
        },
        methods: {
            add_to_cart: function (id) {
                var url = 'shopping/cart/add/?id=' + id;
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        url
                    ).then(response => (this.controller_response = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                }
            },
            load_featured_products: function() {
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        '/products/find/featured'
                    ).then(response => (this.products = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = JSON.parse(this.products);
                }
            }
        },
        mounted(){
            this.load_featured_products();
        }
    }
</script>
<style scoped>
</style>


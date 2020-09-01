<template>
    <div>
        <!-- {% if products is defined %} -->
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <h1 v-if="products !== false">Items in your shopping cart</h1>
        <h1 v-else>You have no items in your shopping cart</h1>
        <div v-if="products && products !== false" v-for="product in products">
            <table class="table">
                <tr>
                    <td>Amount: {{ product.items_in_cart }}</td>
                    <td>Product: {{ product.name }}</td>
                    <td>Product price: {{ product.price }}</td>
                    <td><img :src="'/images/' + product.imageFileName" alt="Image of: " :alt="product.name" class="img-thumbnail"></td>
                    <td><button v-on:click="removeFromCart(product.id)" class="btn btn-danger">Remove from cart</button></td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        name: "list-products",
        data () {
            return {
                products: null,
                controller_response: null
            }
        },
        methods: {
            loadProducts() {
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        '/shopping/cart/find'
                    ).then(response => (this.products = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = JSON.parse(this.products);
                }
            },
            removeFromCart(id) {
                var url = '/shopping/cart/remove/?id=' + id;
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        url
                    ).then(response => (this.controller_response = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = null;
                    setTimeout(function () { this.loadProducts() }.bind(this), 1000)
                }
            }
        },
        mounted(){
            this.loadProducts();
        }
    }
</script>
<style scoped>
</style>


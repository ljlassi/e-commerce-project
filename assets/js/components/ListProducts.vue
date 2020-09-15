<template>
    <div>
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <h2>All products</h2>
        <div v-for="product in products" :key="product.id">
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
        name: "list-products",
        data () {
            return {
                products: null,
                controller_response: null
            }
        },
        methods: {
            add_to_cart: function (product_id) {
                var url = '/api/shopping/cart/alter';
                try {
                    // this.isLoading = true;
                    this.axios.put(
                        url, { id: product_id, add: 1}
                    ).then(response => (this.controller_response = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                }
            },
            load_products: function() {
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        '/api/products/find/all'
                    ).then(response => (this.products = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = JSON.parse(this.products);
                }
            }
        },
        created(){
            this.load_products();
        }
    }
</script>
<style scoped>
</style>


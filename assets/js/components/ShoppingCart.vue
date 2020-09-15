<template>
    <div>
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <h1 v-if="products !== false">Items in your shopping cart</h1>
        <h1 v-else>You have no items in your shopping cart</h1>
        <div v-if="products && products !== false" v-for="product in products" :key="product.id">
            <table class="table">
                <tr>
                    <td>
                            <label for="amount">Amount:</label>
                            <input id="amount" name="amount" v-model="product.items_in_cart" v-bind:key="product.id" type="number" :placeholder="product.items_in_cart">
                            <button class="btn btn-primary" v-on:click="alterCart(product.id, product.items_in_cart)">Update amount</button>
                    </td>
                    <td>Product: {{ product.name }}</td>
                    <td>Product price: {{ product.price }}</td>
                    <td><img :src="'/images/' + product.imageFileName" alt="Image of: " :alt="product.name" class="img-thumbnail"></td>
                    <td><button v-on:click="removeFromCart(product.id)" class="btn btn-danger">Remove from cart</button></td>
                </tr>
            </table>
        </div>
        <div v-if="products !== false && products != null">
            <button v-on:click="emptyCart()" class="btn btn-danger">Empty shopping cart</button>
        </div>
    </div>
</template>
<script>
    export default {
        name: "shopping-cart",
        data () {
            return {
                products: null,
                controller_response: null,
                shopping_cart_amount: null
            }
        },
        methods: {
            loadProducts() {
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        '/api/shopping/cart/find'
                    ).then(response => (this.products = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = JSON.parse(this.products);
                }
            },
            removeFromCart(product_id) {
                var url = '/api/shopping/cart/remove';
                try {
                    // this.isLoading = true;
                    this.axios.put(
                        url, { id: product_id}
                    ).then(response => (this.controller_response = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = null;
                    setTimeout(function () { this.loadProducts() }.bind(this), 1000)
                }
            },
            emptyCart() {
                if (confirm("This action will empty the entire shopping cart. Are you sure?")) {
                    var url = '/api/shopping/cart/empty';
                    try {
                        this.axios.delete(url).then(response => (this.controller_response = response.data));
                    } catch (err) {
                        this.isError = true;
                        console.log("JS error");
                    } finally {
                        this.products = null;
                        setTimeout(function () {
                            this.loadProducts()
                        }.bind(this), 1000)
                    }
                }
            },
            alterCart(product_id, product_amount) {
                var url = '/api/shopping/cart/alter';
                try {
                    // this.isLoading = true;
                    this.axios.put(
                        url, { id: product_id, amount: product_amount}
                    ).then(response => (this.controller_response = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = null;
                    this.shopping_cart_amount = null;
                    setTimeout(function () { this.loadProducts() }.bind(this), 1000)
                }
            },
        },
        created(){
            this.loadProducts();
        }
    }
</script>
<style scoped>
</style>


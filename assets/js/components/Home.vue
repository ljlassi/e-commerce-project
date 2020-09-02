<template>
    <div>
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <h2 class="text-center pb-5">Featured products</h2>
        <div class="row">
            <div v-for="(product, index) in products">
                <div class="col-6">
                    <h3 class="text-center">{{ product.name }}</h3>
                    <p>Price: <b>€{{ product.price }} (VAT included)</b></p>
                    <img :src="'/images/' + product.image_file_name" alt="Image of: " :alt="product.name" class="product-img-responsive">
                    <p><button v-on:click="add_to_cart(product.id)" class="btn btn-primary">Add to cart</button></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "home",
        data () {
            return {
                products: null,
                controller_response: null,
                i: 0
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


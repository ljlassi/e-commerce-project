<template>
    <div>
        <b-container fluid>
            <b-row>
                <b-col cols="12" class="p-0 banner-img-container">
                    <img :src="'/images/' + banner_image_url" alt="Store banner image" class="text-center product-img-responsive">
                </b-col>
            </b-row>
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <h2 class="text-center pb-5">Featured products</h2>
        <b-row align-h="center" class="min-height-300">
            <div v-for="(product, index) in products" :key="product.id">
                <b-col cols="12" lg="6" class="pl-lg-5">
                    <h3 class="text-center">{{ product.name }}</h3>
                    <p class="text-center">Price: <b>€{{ product.price }} (VAT included)</b></p>
                    <img :src="'/images/' + product.image_file_name" alt="Image of: " :alt="product.name" class="text-center product-img-responsive">
                    <p><button v-on:click="add_to_cart(product.id)" class="text-center btn btn-primary">Add to cart</button></p>
                </b-col>
            </div>
        </b-row>
        </b-container>
    </div>
</template>
<script>
    export default {
        name: "home",
        data () {
            return {
                products: null,
                controller_response: null,
                banner_image_url: null
            }
        },
        methods: {
            get_banner_image: function () {
                var url = '/api/cms/banner/get';
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        url
                    ).then(response => (this.banner_image_url = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                }
            },
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
            load_featured_products: function() {
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        '/api/products/find/featured'
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
            this.load_featured_products();
            this.get_banner_image();
        }
    }
</script>
<style scoped>
</style>


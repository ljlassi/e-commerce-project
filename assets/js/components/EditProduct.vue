<template>
    <div>
        <div id="response">
            <p>{{ controller_response }}</p>
        </div>
        <div v-html="editForm" id="edit-form">
        </div>
        <h1 v-if="products !== false">Edit products</h1>
        <h1 v-else>You have no products to edit.</h1>
        <div v-if="products && products !== false" v-for="product in products" :key="product.id">
            <table class="table">
                <tr>
                    <td>Amount: {{ product.items_in_cart }}</td>
                    <td>Product: {{ product.name }}</td>
                    <td>Product price: {{ product.price }}</td>
                    <td><img :src="'/images/' + product.image_file_name" alt="Image of: " :alt="product.name" class="img-thumbnail"></td>
                    <td v-if="product.featured === true"><button v-on:click="unFeatureProduct(product.id)" class="btn btn-danger">Remove from featured products</button></td>
                    <td v-else><button v-on:click="featureProduct(product.id)" class="btn btn-primary">Add to featured products</button></td>
                </tr>
                <tr>
                    <td><button v-on:click="loadEditProduct(product.id)" class="btn btn-primary">Edit Product</button></td>
                    <td><button v-on:click="removeProduct(product.id)" class="btn btn-danger">Remove Product</button></td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        name: "edit-products",
        data () {
            return {
                products: null,
                controller_response: null,
                editForm: null
            }
        },
        methods: {
            loadProducts() {
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
            },
            removeProduct(product_id) {
                var url = '/api/admin/products/remove?id=' + product_id;
                try {
                    // this.isLoading = true;
                    this.axios.delete(
                        url
                    ).then(response => (this.controller_response = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = null;
                    setTimeout(function () { this.loadProducts() }.bind(this), 1500)
                }
            },
            loadEditProduct(id) {
                var url = '/api/admin/products/edit?id=' + id;
                try {
                    this.axios.get(url).then(response => (this.editForm = response.data));
                } catch(err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {

                }
            },
            featureProduct(product_id) {
                var url = '/api/admin/products/featured/action';
                try {
                    this.axios.put(
                        url, { id: product_id}
                    ).then(response => (this.controller_response = response.data));
                } catch(err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = null;
                    setTimeout(function () { this.loadProducts() }.bind(this), 1500)
                }
            },
            unFeatureProduct(product_id) {
                var url = '/api/admin/products/featured/unfeature';
                try {
                    this.axios.put(
                        url, { id: product_id}
                    ).then(response => (this.controller_response = response.data));
                } catch(err) {
                    this.isError = true;
                    console.log("JS error");
                } finally {
                    this.products = null;
                    setTimeout(function () { this.loadProducts() }.bind(this), 1500)
                }
            }
        },
        created(){
            this.loadProducts();
        }
    }
</script>
<style scoped>
</style>


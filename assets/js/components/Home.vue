<template>
    <div>
        <!-- {% if products is defined %} -->
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
                products: null
            }
        },
        methods: {
            add_to_cart: function (id) {
                alert(id)
            },
            load_featured_products: function() {
                try {
                    // this.isLoading = true;
                    this.axios.get(
                        '/products/list/featured'
                    ).then(response => (this.products = response.data));
                } catch (err) {
                    this.isError = true;
                    console.log(err);
                } finally {
                    this.products = JSON.parse(this.products);
                    console.log("Loaded!");
                    //this.isLoading = false;
                }
            }
        },
        mounted(){
            this.load_featured_products();
        }
    }

    /**
     * <    <table class="table">
     {% for product in products %}
     <tr>
     <td>Product: {{ product.name }}</td>
     <td>Product price:{{ product.price }}</td>
     <td><img src="{{ asset("images/") ~ product.imageFileName }}" alt="product image" class="img-thumbnail"></td>
     </tr>
     <tr>
     <td><button v-on:click="add_to_cart({{ product.id }})" class="btn btn-primary">Add to cart</button></td>
     </tr>
     {% endfor %}
     </table>
     {% else %}
     <h4>No featured products set yet</h4>
     {% endif %}
      */
</script>
<style scoped>
</style>


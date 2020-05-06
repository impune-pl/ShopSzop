<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-md-12 row justify-content-center">
                    <ul class="list-group list-group-horizontal">
                        <li v-for="(category) in categories" class="list-group-item-action list-group-item" v-bind:class="{'active': category.id === activeCategoryId}" v-on:click="changeCategory(category.id,$event)">{{category.name}}</li>
                    </ul>
                </div>
                <div class="card col-md-12 card-deck">
                    <div v-for="(product) in products" class="card col-md-6 mb-1 mt-1" style="min-width: 18rem;max-width: 319px;padding-right: 0;">
                        <router-link :to="{ path: '/products/'+product.id}">
                            <img :src="product.image_path"  class="card-img-top rounded" style="max-width: 317px" alt="Image not found, contact administrator">
                            <div class="card-body">
                                <h5 class="card-title">{{product.name}}</h5>
                                <h6 class="card-subtitle">Price: {{product.price}}$</h6>
                                <div class="card-text col-12" v-on:click="handleAddToCart(product.id, $event)">Add to cart</div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div ref="toast_ok" id="toast_ok" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="mr-auto">Item added to basket.</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div ref="toast_bad" id="toast_bad" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="mr-auto">Error while adding item to basket.</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data()
        {
            return {
                products: [],
                categories: [],
                activeCategoryId: null
            }
        },
        mounted()
        {
            axios.get("api/products/")
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
            axios.get("api/categories/")
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        methods: {
            handleAddToCart(productId, e) {
                e.preventDefault();
                axios.post('/api/products/'+productId+'/to-basket').then(res=>{
                    if(res.data.status === true)
                    {
                        this.$refs.toast_ok.toast({
                                delay: 300,
                                autohide:true,
                                animation:true
                            });
                        this.$bvToast
                    }
                    else
                    {
                        this.$refs.toast_bad.toast({
                            delay: 300,
                            autohide:true,
                            animation:true
                        });
                    }
                });
            },
            changeCategory(categoryId, e)
            {
                if(categoryId===this.activeCategoryId)
                {
                    this.activeCategoryId=null;
                }
                else
                {
                    this.activeCategoryId=categoryId;
                }
                axios.get("api/products/")
                    .then(response => {
                        let tmpProducts = response.data;
                        if(this.activeCategoryId !== null)
                            this.products = tmpProducts.filter((product) => {
                                return this.activeCategoryId === product.category_id;
                            });
                        else
                            this.products=tmpProducts;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-md-12 justify-content-center">
                    <ul class="list-group list-group-horizontal list-group-flush">
                        <li v-for="(category) in categories" class="border-top-0 border-bottom-0 shadow-sm list-group-item-action center-text flex-fill list-group-item" v-bind:class="{'active': category.id === activeCategoryId}" v-on:click="changeCategory(category.id,$event)">{{category.name}}</li>
                    </ul>
                </div>
                <div class="card-deck center-items">
                    <div v-for="(product) in products" class="card rounded-0 border-0 shadow-sm mb-1 mt-2 p-0" style="min-width: 18rem;max-width: 319px;">
                        <router-link :to="{ path: '/products/'+product.id}" class="text-decoration-none">
                            <img :src="product.image_path"  class="card-img-top rounded" style="max-width: 317px" alt="Image not found, contact administrator">
                            <div class="card-body">
                                <h5 class="card-title text-reset">{{product.name}}</h5>
                                <h6 class="text-dark text-decoration-none">Price: {{product.price}}$</h6>
                                <div class="card-text justify-content-center align-content-center p-0 col-12" v-on:click="handleAddToCart(product.id, $event)"><button class="btn btn-outline-primary w-100">Add to cart</button></div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div id="toaster_ok" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center" style="pointer-events: none; position:fixed; top:0px; left:0px; width:100%; height: 100%;">
            <div ref="toast_ok" id="toast_ok" class="toast mt-5 border-0 rounded-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true" style="height: 32px">
                <div class="toast-header text-success">
                    <strong class="mr-auto">Item added to basket.</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                </div>
            </div>
        </div>
        <div id="toaster_bad" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center" style="pointer-events: none; position:fixed; top:0px; left:0px; width:100%; height: 100%;">
            <div ref="toast_bad" id="toast_bad" class="toast mt-5 border-0 rounded-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true" style="height: 32px">
                <div class="toast-header text-danger">
                    <strong class="mr-auto">Error while adding item to basket.</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                </div>
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
            axios.get("/api/products/")
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
            axios.get("/api/categories/")
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
            $('#toast_ok').toast({
                delay: 1200,
            });
            $('#toast_bad').toast({
                delay: 1200,
            });
        },
        methods: {
            test(){
                $('#toast_ok').toast('show')
            },
            handleAddToCart(productId, e) {
                e.preventDefault();
                axios.post('/api/products/'+productId+'/to-basket').then(res=>{
                    if(res.data.status === true)
                    {
                        $('#toast_ok').toast('show');
                    }
                    else
                    {
                        $('#toast_bad').toast('show');
                    }
                }).catch(()=>{
                    $('#toast_bad').toast('show');
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
                axios.get("/api/products/")
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
    .center-text {
        display: inline-flex;
        align-items: center !important;
        align-content: center !important;
        justify-content: center;
    }
    .center-items    {
        align-items: center !important;
        align-content: center !important;
        justify-content: center;
    }
</style>

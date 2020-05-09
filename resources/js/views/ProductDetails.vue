<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card col-md-12 p-0">
                    <img :src="'/'+product.image_path"  class="card-img-top rounded" style="" alt="Image not found, contact administrator">
                    <div class="card-body">
                        <h5 class="card-title text-reset">{{product.name}}</h5>
                        <h6 class="text-dark text-decoration-none">Price: {{product.price}}$</h6>
                        <div class="card-text justify-content-center align-content-center p-0 col-12" v-on:click="handleAddToCart(product.id, $event)">
                            <span>{{product.description}}</span>
                            <button class="btn btn-outline-primary w-100">Add to cart</button>
                        </div>
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
        data() {
            return {
                product: null
            }
        },
        mounted()
        {
            axios.get("/api/products/"+this.$route.params.id)
                .then(response => {
                    this.product = response.data;
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
            handleAddToCart()
            {
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
            }
        }
    }
</script>

<style scoped>

</style>

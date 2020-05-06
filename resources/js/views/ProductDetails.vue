<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card col-md-12">
                    <img :src="product.image_path"  class="card-img-top rounded" style="max-width: 317px" alt="Image not found, contact administrator">

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
            axios.get("api/products/"+this.$route.params.product)
                .then(response => {
                    this.product = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        methods: {
            handleAddToCart()
            {
                axios.post('/api/products/productId/to-basket').then(res=>{
                    if(res.data.status === true)
                    {
                        this.$refs.toast_ok.toast({
                            delay: 300,
                            autohide:true,
                            animation:true
                        });
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
            }
        }
    }
</script>

<style scoped>

</style>

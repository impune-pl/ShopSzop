<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container shadow-sm">
                    <div class="row pl-1 pt-1 pb-1">
                        <h2>Your cart:</h2>
                    </div>
                    <div class="row shadow-sm">
                        <div class="col">Name</div>
                        <div class="col">Quantity</div>
                        <div class="col">Unit price</div>
                        <div class="col">Total price</div>
                        <div class="col-sm">Remove</div>
                    </div>
                    <div v-for="(product) in products" class="row mt-2 pb-2 shadow-sm align-middle">
                        <div class="col-sm center-text">
                            <router-link :to="{ path: '/products/'+product.product.id}"> {{product.product.name}} </router-link>
                        </div>
                        <div class="col-sm center-text">
                            <input class="form-control" v-model.number="product.amount" type="number" v-on:change="(e)=>changeQuantity(product.id, product.amount, e)">
                        </div>
                        <div class="col-sm center-text">
                            {{product.product.price}}
                        </div>
                        <div class="col-sm center-text">
                            {{parseFloat(product.amount * product.product.price).toFixed(2)}}
                        </div>
                        <div class="col-sm center-text">
                            <button class="btn btn-link text-danger-on-hover" v-on:click="(e)=>remove(product.id,e)"><font-awesome-icon :icon="['fas','trash']"></font-awesome-icon></button>
                        </div>
                    </div>
                    <div class="row mt-3 pb-3">
                        <div class="col-sm center-text">
                            <button class="btn btn-link text-danger-on-hover" v-on:click="(e)=>clear(e)"><font-awesome-icon :icon="['fas','trash']"></font-awesome-icon></button>
                        </div>
                        <div class="col-sm center-text"></div>
                        <div class="col-sm center-text"></div>
                        <div class="col-sm center-text"></div>
                        <div class="col-sm center-text">
                            <router-link :to="{name: 'checkout'}">
                                <button class="btn btn-link"><font-awesome-icon :icon="['fas','cash-register']"></font-awesome-icon></button>
                            </router-link>
                        </div>
                    </div>
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
            }
        },
        mounted()
        {
            axios.get("/api/basket/")
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        methods: {
            changeQuantity(productId, quantity, e) {
                e.preventDefault();
                axios.patch("/api/basket/"+productId+"/"+quantity).then(()=>
                {
                    this.refresh();
                }).catch(error =>
                {
                    console.error(error);
                });
            },
            remove(productId, e)
            {
                e.preventDefault();
                axios.patch("/api/basket/"+productId+"/").then(()=>
                {
                    this.refresh();
                }).catch(error =>
                {
                    console.error(error);
                });
            },
            refresh()
            {
                axios.get("/api/basket/")
                    .then(response => {
                        this.products = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            clear(e)
            {
                e.preventDefault();
                axios.delete('/api/basket').then(()=>{
                    this.refresh();
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
    }
    .text-danger-on-hover:hover
    {
        color:#e3342f;
    }
    .text-danger-on-hover
    {
        color:#6c757d;
    }
</style>

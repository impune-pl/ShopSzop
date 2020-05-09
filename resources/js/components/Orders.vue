<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="container">
                    <div class="row shadow-sm mb-3 mt-3 pb-2 pt-2">
                        <div class="col">
                            Order number
                        </div>
                        <div class="col">
                            Order date
                        </div>
                        <div class="col">
                            Status
                        </div>
                        <div class="col">
                            Paid
                        </div>
                        <div class="col">
                            Delivered
                        </div>
                        <div class="col">
                            Details
                        </div>
                    </div>
                    <div v-for="(order) in orders">
                        <div class="row shadow-sm mb-2 mt-0">
                            <div class="col">
                                {{order.id}}
                            </div>
                            <div class="col">
                                {{order.order_date}}
                            </div>
                            <div class="col" v-if="order.is_delivered">
                                Delivered
                            </div>
                            <div class="col" v-else-if="order.payment_id!==0">
                                Paid
                            </div>
                            <div class="col" v-else>
                                Placed
                            </div>
                            <div class="col">
                                <button v-on:click="makePaid(order.id)" v-bind:class="{'text-green': order.payment_id!==0}" type="button" class="btn text-green-on-hover btn-link"><font-awesome-icon :id="'fa-paid-'+order.id" :icon="['fas','credit-card']"></font-awesome-icon></button>
                            </div>
                            <div class="col">
                                <button v-on:click="makeDelivered(order.id)" v-bind:class="{'text-green': order.is_delivered}" type="button" class="btn text-green-on-hover btn-link"><font-awesome-icon :id="'fa-delivery-'+order.id" :icon="['fas','truck-loading']"></font-awesome-icon></button>
                            </div>
                            <div class="col">
                                <button v-on:click="toggleCollapse(order.id)"  type="button" class="btn btn-link"><font-awesome-icon :id="'fa'+order.id" :icon="['fas','caret-down']"></font-awesome-icon></button>
                            </div>
                        </div>
                        <div class="collapse row" :id="'coll'+order.id">
                            <div class="col-8 ml-5">
                                <div class="row shadow-sm">
                                    <div class="col">Name</div>
                                    <div class="col">Quantity</div>
                                    <div class="col">Unit price</div>
                                    <div class="col">Total price</div>
                                </div>
                                <div v-for="(product) in order.products" class="row mt-2 pb-2 shadow-sm align-middle">
                                    <div class="col-sm center-text">
                                        <router-link :to="{ path: '/products/'+product.product.id}"> {{product.product.name}} </router-link>
                                    </div>
                                    <div class="col-sm center-text">
                                        {{product.amount}}
                                    </div>
                                    <div class="col-sm center-text">
                                        {{product.product.price}}
                                    </div>
                                    <div class="col-sm center-text">
                                        {{parseFloat(product.amount * product.product.price).toFixed(2)}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 offset-6">
                                <div class="shadow-sm border-0 rounded-0">
                                    <p>Order price: {{getTotalOrderPrice(order.id)}} $</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                        </div>
                        <div class="col">
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
                orders: [],
            }
        },
        mounted()
        {
            axios.get("/api/orders/all")
                .then(response => {
                    this.orders = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        methods:
            {
                animateRotation(id)
                {
                    $('#fa'+id).toggleClass('fa-rotate-180');
                },
                toggleCollapse(id)
                {
                    this.animateRotation(id);
                    $('#coll'+id).collapse('toggle');
                },
                getTotalOrderPrice(id)
                {
                    let totalPrice = 0.0;
                    this.orders.forEach((value)=>
                    {
                        if(value.id === id)
                        {
                            value.products.forEach((value1)=>
                            {
                                totalPrice += parseFloat(value1.amount) * parseFloat(value1.product.price);
                            });
                        }
                    });
                    return parseFloat(totalPrice).toFixed(2)
                },
                makePaid(id)
                {
                    axios.patch("/api/orders/"+id+"/pay")
                        .then(response => {
                            this.refresh();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
                makeDelivered(id)
                {
                    axios.patch("/api/orders/"+id+"/deliver")
                        .then(response => {
                            this.refresh();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
                refresh()
                {
                    axios.get("/api/orders/all")
                        .then(response => {
                            this.orders = response.data;
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
    }
    .text-green-on-hover:hover
    {
        color:#38c172;
    }
    .text-green-on-hover
    {
        color:#6c757d;
    }
    .text-green
    {
        color:#38c172;
    }
</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row shadow-sm justify-content-center pb-2">
                    <form>
                        <div class="row form-group">
                            <label for="first_line">Address</label>
                            <input type="text" class="form-control"  id="first_line" name="first_line" v-model="shipping_address.first_line">
                        </div>
                        <div class="row form-group">
                            <input type="text" class="form-control" id="second_line" name="second_line" v-model="shipping_address.second_line">
                        </div>
                        <div class="row form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" v-model="shipping_address.city">
                        </div>
                        <div class="row form-group">
                            <div class="col-50">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" v-model="shipping_address.country">
                            </div>
                            <div class="col-50">
                                <label for="postal_code">Zip</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" v-model="shipping_address.postal_code">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <button class="btn btn-primary" v-on:click="(e)=>send(e)">Proceed</button>
                        </div>
                    </form>
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
                shipping_address: {city:"",country:"",postal_code:"",first_line:"",second_line:""}
            }
        },
        mounted()
        {
        },
        methods:
            {
                send(e)
                {
                    e.preventDefault();
                    axios.post('/api/order/place',{
                        shipping_address: this.shipping_address
                    }).then((response)=>
                    {
                        //Display confirmation/payment info/redirect to payment idk.
                    }).catch(error => {
                        console.error(error);
                    });
                    this.$router.push({name: 'orders'});
                }
            }
    }
</script>

<style scoped>

</style>

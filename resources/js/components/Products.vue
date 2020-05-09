<template>

</template>

<script>
    export default {
        name: "Products",
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

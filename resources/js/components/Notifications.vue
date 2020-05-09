<template>
    <div class="container shadow-sm pb-3">
        <form v-on:submit.prevent>
            <p>Notify: </p>
            <div class="row pl-3 mb-3">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="customRadioInline1" v-model="isForAll" v-bind:value="false" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1" >Single user</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline1" v-model="isForAll" v-bind:value="true" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">All users</label>
                </div>
            </div>
            <label v-if="!isForAll" for="notificationRecipient">Recipient's email</label>
            <input v-if="!isForAll" class="form-control" v-model="recipientEmail" id="notificationRecipient" name="notificationRecipient" type="email">
            <label for="notifiactionText">Message</label>
            <textarea class="form-control mb-2" id="notifiactionText" v-model="notificationText" name="notifiactionText" rows="10"></textarea>
            <button type="button" v-on:click="(e)=>send(e)" class="btn btn-primary">Send</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Notifications",
        data()
        {
            return {
                notificationText: '',
                recipientEmail: '',
                isForAll: false
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
                    if(this.isForAll)
                    {
                        axios.post('/api/notify',{
                            notificationText: this.notificationText
                        }).catch(error => {
                            console.error(error);
                        });
                    }
                    else
                    {
                        axios.post('/api/'+this.recipientEmail+'/notify',{
                            notificationText: this.notificationText
                        }).catch(error => {
                            console.error(error);
                        });
                    }
                }
            }
    }
</script>

<style scoped>

</style>

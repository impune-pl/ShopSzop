<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="container">
                    <div class="row shadow-sm mb-3 mt-3 pb-2 pt-2">
                        <div class="col center-text">
                            Name
                        </div>
                        <div class="col center-text">
                            Email
                        </div>
                        <div class="col center-text">
                            Banned
                        </div>
                        <div class="col center-text">
                            Type
                        </div>
                    </div>
                    <div class="row shadow-sm mb-2 mt-0" v-for="(user) in users">
                        <div class="col center-text">
                            {{user.name}}
                        </div>
                        <div class="col center-text">
                            {{user.email}}
                        </div>
                        <div class="col center-text">
                            <button v-on:click="toggleBan(user.id, user.isBanned)" v-bind:class="{'text-green-on-hover': user.isBanned, 'text-red-on-hover': !user.isBanned, 'text-green': !user.isBanned, 'text-red': user.isBanned}" type="button" class="btn btn-link">
                                <font-awesome-icon v-if="user.isBanned" :icon="['fas','lock']"></font-awesome-icon>
                                <font-awesome-icon v-else :icon="['fas','lock-open']"></font-awesome-icon>
                            </button>
                        </div>
                        <div class="col center-text">
                            <button v-on:click="toggleAdmin(user.id, user.isAdmin)" v-bind:class="{'text-green-on-hover': !user.isAdmin, 'text-red-on-hover': user.isAdmin, 'text-green': user.isAdmin, 'text-red': !user.isAdmin}" type="button" class="btn btn-link">
                                <font-awesome-icon v-if="user.isAdmin" :icon="['fas','hashtag']"></font-awesome-icon>
                                <font-awesome-icon v-else :icon="['fas','dollar-sign']"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Users",
        data()
        {
            return {
                users: [],
            }
        },
        mounted()
        {
            axios.get("/api/users/all")
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        methods:
            {
                toggleAdmin(id, isAdmin)
                {
                    if(isAdmin)
                    {
                        axios.patch('/api/users/'+id+'/unadmin')
                            .then(response => {
                                this.refresh();
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                    else
                    {
                        axios.patch('/api/users/'+id+'/admin')
                            .then(response => {
                                this.refresh();
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                },
                toggleBan(id, isBanned)
                {
                    if(isBanned)
                    {
                        axios.patch('/api/users/'+id+'/unban')
                            .then(response => {
                                this.refresh();
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                    else
                    {
                        axios.patch('/api/users/'+id+'/ban')
                            .then(response => {
                                this.refresh();
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                },
                refresh()
                {
                    axios.get("/api/users/all")
                        .then(response => {
                            this.users = response.data;
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
    .text-green
    {
        color:#38c172;
    }
    .text-red-on-hover:hover
    {
        color:#e3342f;
    }
    .text-red
    {
        color:#e3342f;
    }

</style>

<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark ">
            <div class="container">
                <router-link :to="{name: 'home'}" class="navbar-brand">Szop Shop</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li clss="nav-item"><router-link :to="{name:'products'}" class="nav-link">Products</router-link> </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                        <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
                        <span v-if="isLoggedIn">
                            <router-link :to="{ name: 'dashboard' }" class="nav-link" v-if="user_type === false"> Hi, {{name}}</router-link>
                            <router-link :to="{ name: 'admin' }" class="nav-link" v-if="user_type === true"> Hi, {{name}}</router-link>
                            <router-link :to="{ name: 'basket'}" class="nav-link"><font-awesome-icon :icon="['fas','shopping-cart']"></font-awesome-icon></router-link>
                        </span>
                        <li class="nav-link" v-if="isLoggedIn" @click="logout"> Logout</li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view v-on:loggedin="change"></router-view>
        </main>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                name        : null,
                user_type   : 0,
                isLoggedIn  : localStorage.getItem('SzopShop.jwt') != null
            }
        },
        mounted() {
            this.setDefaults()
        },
        methods : {
            setDefaults(){
                if(this.isLoggedIn){
                    let user        = JSON.parse(localStorage.getItem('SzopShop.user'));
                    this.name       = user.name;
                    this.user_type  = user.is_admin;
                }
            },
            change(){
                this.isLoggedIn = localStorage.getItem('SzopShop.jwt') != null;
                this.setDefaults();
            },
            logout(){
                localStorage.removeItem('SzopShop.jwt');
                localStorage.removeItem('SzopShop.user');
                this.change();
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>

</style>

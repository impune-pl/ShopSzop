<template>
    <div class="container">
        <div class="row justify-content-center">
            <ul class="list-group list-group-horizontal list-group-flush ">
                <li class="border-top-0 border-bottom-0 shadow-sm list-group-item-action center-text flex-fill list-group-item" v-bind:class="{active: (this.activeComponentName === 'main' || this.activeComponentName ===  'notifications')}" v-on:click="setComponent('notifications')">Notifications</li>
                <li class="border-top-0 border-bottom-0 shadow-sm list-group-item-action center-text flex-fill list-group-item" v-bind:class="{active: (this.activeComponentName ===  'orders')}" v-on:click="setComponent('orders')">Orders</li>
                <li class="border-top-0 border-bottom-0 shadow-sm list-group-item-action center-text flex-fill list-group-item" v-bind:class="{active: (this.activeComponentName ===  'products')}"  v-on:click="setComponent('products')">Products</li>
                <li class="border-top-0 border-bottom-0 shadow-sm list-group-item-action center-text flex-fill list-group-item" v-bind:class="{active: (this.activeComponentName ===  'users')}" v-on:click="setComponent('users')">Users</li>
            </ul>
            <div class="col-md-9 mt-2">
                <component :is="this.activeComponent"></component>
            </div>
        </div>
    </div>
</template>

<script>
    import Notifications from '../components/Notifications';
    import Users from '../components/Users';
    import Products from '../components/Products';
    import Orders from '../components/Orders';

    export default {
        data() {
            return {
                user: null,
                activeComponent: null,
                activeComponentName: ''
            }
        },
        components: {
            Main: Notifications, Users, Products, Orders
        },
        beforeMount() {
            this.setComponent(this.$route.params.path);
        },
        methods: {
            setComponent(value) {
                this.activeComponentName = value;
                switch(value) {
                    case "users":
                        this.activeComponent = Users;
                        this.$router.push({name: 'admin_path', params: {path: 'users'}});
                        break;
                    case "orders":
                        this.activeComponent = Orders;
                        this.$router.push({name: 'admin_path', params: {path: 'orders'}});
                        break;
                    case "products":
                        this.activeComponent = Products;
                        this.$router.push({name: 'admin_path', params: {path: 'products'}});
                        break;
                    default:
                        this.activeComponent = Notifications;
                        this.$router.push({name: 'admin', params: {path: 'notifications'}});
                        break;
                }
            }
        }
    }
</script>

<style scoped>
</style>

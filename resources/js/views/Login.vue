<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default rounded-0 border-0 shadow-sm">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input ref="email "id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-sm-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input ref="password" id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 row justify-content-end">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {email:"",password:""};
        },
        methods: {
            handleSubmit(e)
            {
                e.preventDefault();
                if (this.password.length > 0 && this.email.length > 0) {
                    let email = this.email;
                    let password = this.password;

                    axios.post('api/login', {email, password}).then(res => {
                        let user = res.data.user;
                        let is_admin = user.isAdmin;
                        let is_banned = user.isBanned;
                        if(is_banned)
                        {
                            this.$router.push({name:'rules'});
                            return;
                        }

                        localStorage.setItem('SzopShop.user', JSON.stringify(user));
                        localStorage.setItem('SzopShop.jwt', res.data.token);

                        if (localStorage.getItem('SzopShop.jwt') != null)
                        {
                            this.$emit('loggedin');
                            if (this.$route.params.nextUrl != null)
                            {
                                this.$router.push(this.$route.params.nextUrl);
                            }
                            else
                            {
                                this.$router.push((is_admin === true ? {name:'admin_orders'} : {name:'orders'}));
                            }
                        }
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-0 card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required @change="emailChange">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input ref="password" id="password" type="password" class="form-control" v-model="password" required @change="passwordChange">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input ref="password-confirm" id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required @change="passwordChange">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 row justify-content-end">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Register
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
        props : ['nextUrl'],
        data(){
            return {
                name : "",
                email : "",
                password : "",
                password_confirmation : ""
            }
        },
        methods : {
            handleSubmit(e)
            {
                e.preventDefault()
                if (this.password !== this.password_confirmation || this.password.length <= 0)
                {
                    return alert('Passwords do not match');
                }
                let name = this.name;
                let email = this.email;
                let password = this.password;
                let c_password = this.password_confirmation;
                axios.post('api/register', {name, email, password, c_password}).then(response => {
                    let data = response.data;
                    localStorage.setItem('ShopSzop.user', JSON.stringify(data.user));
                    localStorage.setItem('ShopSzop.jwt', data.token);
                    if (localStorage.getItem('ShopSzop.jwt') != null)
                    {
                        this.$emit('loggedIn');
                        let nextUrl = this.$route.params.nextUrl;
                        this.$router.push((nextUrl != null ? nextUrl : '/'));
                    }
                })
            },
            passwordChange(e)
            {
                e.preventDefault();
                if (this.password !== this.password_confirmation && this.password.length >= 0)
                {
                    if(this.$refs["password"].classList.contains("is-valid"))
                    {
                        this.$refs["password"].classList.remove("is-valid");
                        this.$refs["password-confirm"].classList.remove("is-valid");
                    }
                    if( ! this.$refs["password"].classList.contains("is-invalid"))
                    {
                        this.$refs["password"].classList.add("is-invalid");
                        this.$refs["password-confirm"].classList.add("is-invalid");
                    }
                } else if(this.password === this.password_confirmation && this.password.length >= 8)
                {
                    if( ! this.$refs["password"].classList.contains("is-valid"))
                    {
                        this.$refs["password"].classList.add("is-valid");
                        this.$refs["password-confirm"].classList.add("is-valid");
                    }
                    if(this.$refs["password"].classList.contains("is-invalid"))
                    {
                        this.$refs["password"].classList.remove("is-invalid");
                        this.$refs["password-confirm"].classList.remove("is-invalid");
                    }
                } else
                {
                    if(this.$refs["password"].classList.contains("is-valid"))
                    {
                        this.$refs["password"].classList.remove("is-valid");
                        this.$refs["password_confirmation"].classList.remove("is-valid");
                    }
                    if(this.$refs["password"].classList.contains("is-invalid"))
                    {
                        this.$refs["password"].classList.remove("is-invalid");
                        this.$refs["password_confirmation"].classList.remove("is-invalid");
                    }
                }
            },
            emailChange(e)
            {
                e.preventDefault();
            }
        }
    }
</script>

<style scoped>

</style>

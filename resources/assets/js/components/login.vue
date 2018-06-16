<template>
<div class="col-md-5 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Login First</h4>
        </div>
        <div class="panel-body">
            <form @submit.prevent="login" id="login_form">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" required/>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required/>
                </div>

                <label>
                    <input 
                        type="checkbox" 
                        onclick=" $(this)[0].checked ? 
                                    $('[name=password]').attr('type','text'):
                                    $('[name=password]').attr('type','password')"/> Show Password
                </label>

                <div class="form-group">
                    <input type="submit" value="Login" class="btn btn-primary form-control"/>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default{
    
    data: function () {
        return {
            loading: false
        }
    },

    created: function(){
        if(this.util.isLogin())
            this.$router.push({name: 'Home'});
    },

    methods: {
        login: function () {
            if (this.loading) return;
            var vm = this;
            this.loading = true;
            this.util.notify('Logging in Please wait', 'loading');
            axios.post(this.data.API+'admin/login', $('#login_form').serialize())
                .then(response=>{
                    vm.loading = false;
                    $.notifyClose();
                    if (vm.util.showResult(response, 'success')) {
                        vm.util.setAuthorization(response.data.ACCESS_TOKEN);
                        vm.$router.push({name: 'Home'});
                    }
                })
                .catch(error=>{
                    vm.loading = false;
                    $.notifyClose();
                    vm.util.showResult(error, 'error');
                })
        }
    }
}
</script>

<style>
body {
    padding: 50px 5px;
}
</style>

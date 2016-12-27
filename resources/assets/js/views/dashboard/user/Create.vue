<template>
    <vue-form :title="$t('form.create_user')">
        <div slot="buttons">
            <router-link to="/dashboard/users" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="create">
                    <div class="form-group">
                        <label for="name">{{ $t('form.name') }}</label>
                        <input type="text" class="form-control" id="name" :placeholder="$t('form.name')" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">{{ $t('form.email') }}</label>
                        <input type="email" class="form-control" id="email" :placeholder="$t('form.email')" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">{{ $t('form.password') }}</label>
                        <input type="password" class="form-control" id="password" :placeholder="$t('form.password')" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">{{ $t('form.confirm_password') }}</label>
                        <input type="password" class="form-control" id="password_confirmation" :placeholder="$t('form.confirm_password')" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $t('form.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    import { stack_error } from '../../../config/helper.js'

    export default {
        methods: {
            create(event) {
                const formData = new FormData(event.target)

                this.$http.post('/api/user', formData)
                    .then((response) => {
                        toastr.success('You create a new account success!')

                        this.$router.push('/dashboard/users')
                    }, (response) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

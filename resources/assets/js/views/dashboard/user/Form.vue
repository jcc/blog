<template>
    <div class="row">
        <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="onSubmit">
            <div class="form-group text-center">
                <img :src="user.avatar ? user.avatar : 'https://pigjian.com/uploads/default_avatar.png'" id="avatar" class="img-circle" width="100" :alt="user.name">
            </div>
            <div class="form-group">
                <label for="name">{{ $t('form.name') }}</label>
                <input type="text" class="form-control" id="name" :placeholder="$t('form.name')" v-model="user.name" :disabled="user.id ? true : false">
            </div>
            <div class="form-group">
                <label for="email">{{ $t('form.email') }}</label>
                <input type="email" class="form-control" id="email" :placeholder="$t('form.email')" v-model="user.email">
            </div>
            <div class="form-group">
                <label for="nickname">{{ $t('form.nickname') }}</label>
                <input type="text" class="form-control" id="nickname" :placeholder="$t('form.nickname')" v-model="user.nickname">
            </div>
            <div class="form-group">
                <label for="website">{{ $t('form.website') }}</label>
                <input type="text" class="form-control" id="website" :placeholder="$t('form.website')" v-model="user.website">
            </div>
            <div class="form-group">
                <label for="description">{{ $t('form.description') }}</label>
                <input type="text" class="form-control" id="description" :placeholder="$t('form.description')" v-model="user.description">
            </div>
            <template v-if="!user.id">
                <div class="form-group">
                    <label for="password">{{ $t('form.password') }}</label>
                    <input type="password" class="form-control" id="password" :placeholder="$t('form.password')" name="password" v-model="user.password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ $t('form.confirm_password') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" :placeholder="$t('form.confirm_password')" name="password_confirmation" v-model="user.password_confirmation">
                </div>
            </template>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ user.id ? $t('form.edit') : $t('form.create') }}</button>
            </div>
        </form>
    </div>
</template>

<script>
import { stack_error } from 'config/helper'

export default {
    props: {
        user: {
            type: Object,
            default() {
                return {}
            }
        },
    },
    computed: {
        mode() {
            return this.user.id ? 'update' : 'create'
        },
    },
    methods: {
        onSubmit() {
            let url = 'user' + (this.user.id ? '/' + this.user.id : '')
            let method = this.user.id ? 'patch' : 'post'

            this.$http[method](url, this.user)
                .then((response) => {
                    toastr.success('You ' + this.mode + 'd a new account information!')

                    this.$router.push('/dashboard/users')
                }).catch(({ response }) => {
                    stack_error(response)
                })
        }
    },
}
</script>

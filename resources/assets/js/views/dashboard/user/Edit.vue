<template>
    <vue-form :title="$t('form.edit_user')">
        <div slot="buttons">
            <router-link to="/dashboard/users" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="edit">
                    <div class="form-group text-center">
                        <img :src="user.avatar ? user.avatar : 'https://pigjian.com/uploads/default_avatar.png'" id="avatar" class="img-circle" width="100" :alt="user.name">
                    </div>
                    <div class="form-group">
                        <label for="name">{{ $t('form.name') }}</label>
                        <input type="text" class="form-control" id="name" :placeholder="$t('form.name')" v-model="user.name" disabled>
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $t('form.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    export default{
        data() {
            return {
                user: {}
            }
        },
        created() {
            this.$http.get('user/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.user = response.data.data
                })
        },
        methods: {
            edit() {
                this.$http.put('user/' + this.$route.params.id, this.user)
                    .then((response) => {
                        toastr.success('You updated a new account information!')

                        this.$router.push('/dashboard/users')
                    })
            }
        }
    }
</script>

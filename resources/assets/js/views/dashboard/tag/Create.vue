<template>
    <vue-form :title="$t('form.create_tag')">
        <div slot="buttons">
            <router-link to="/dashboard/tags" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="create">
                    <div class="form-group">
                        <label for="tag">{{ $t('form.tag') }}</label>
                        <input type="text" class="form-control" id="tag" :placeholder="$t('form.tag')" name="tag">
                    </div>
                    <div class="form-group">
                        <label for="title">{{ $t('form.title') }}</label>
                        <input type="text" class="form-control" id="title" :placeholder="$t('form.title')" name="title">
                    </div>
                    <div class="form-group">
                        <label for="meta_description">{{ $t('form.meta_description') }}</label>
                        <textarea class="form-control" name="meta_description" id="meta_description" :placeholder="$t('form.meta_description')"></textarea>
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
                var formData = new FormData(event.target)

                this.$http.post('/api/tag', formData)
                    .then((response) => {
                        toastr.success('You created a new tag success!')

                        this.$router.push('/dashboard/tags')
                    }, (response) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>


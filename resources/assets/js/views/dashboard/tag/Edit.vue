<template>
    <vue-form :title="$t('form.edit_tag')">
        <div slot="buttons">
            <router-link to="/dashboard/tags" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="edit">
                    <div class="form-group">
                        <label for="tag">{{ $t('form.tag') }}</label>
                        <input type="text" class="form-control" id="tag" :placeholder="$t('form.tag')" name="tag" v-model="tag.tag" disabled>
                    </div>
                    <div class="form-group">
                        <label for="title">{{ $t('form.title') }}</label>
                        <input type="text" class="form-control" id="title" :placeholder="$t('form.title')" name="title" v-model="tag.title">
                    </div>
                    <div class="form-group">
                        <label for="meta_description">{{ $t('form.meta_description') }}</label>
                        <textarea class="form-control" name="meta_description" id="meta_description" :placeholder="$t('form.meta_description')" v-model="tag.meta_description"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ $t('form.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    import { stack_error } from '../../../config/helper.js'

    export default {
        data() {
            return {
                tag: {}
            }
        },
        created() {
            this.$http.get('/api/tag/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.tag = response.data.data
                })
        },
        methods: {
            edit() {
                this.$http.put('/api/tag/' + this.$route.params.id, this.tag)
                    .then((response) => {
                        toastr.success('You updated the tag information success!')

                        this.$router.push('/dashboard/tags')
                    }, (response) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

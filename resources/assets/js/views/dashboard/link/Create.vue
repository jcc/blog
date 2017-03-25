<template>
    <vue-form :title="$t('form.create_link')">
        <div slot="buttons">
            <router-link to="/dashboard/links" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="create" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">{{ $t('form.link_name') }}</label>
                        <input type="text" class="form-control" id="name" :placeholder="$t('form.link_name')" name="name">
                    </div>
                    <div class="form-group">
                        <label for="link">{{ $t('form.link') }}</label>
                        <input type="link" class="form-control" id="link" :placeholder="$t('form.link')" name="link">
                    </div>
                    <div class="form-group">
                        <label for="image">{{ $t('form.image') }}</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <label>{{ $t('form.is_enable') }}</label>
                        <div class="togglebutton" style="margin-top: 6px">
                            <label>
                                <input type="checkbox" name="status">
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ $t('form.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    import { stack_error } from '../../../config/helper.js'

    export default{
        data(){
            return{
            }
        },
        methods: {
            create(event) {
                const formData = new FormData(event.target)

                const file = event.target.files

                formData.append('image', file)

                if (!formData.get('image').size) {
                    toastr.error('The image is required!')
                    return
                }

                this.$http.post('link', formData)
                    .then((response) => {
                        toastr.success('You created a new link success!')

                        this.$router.push('/dashboard/links')
                    }).catch(({response}) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

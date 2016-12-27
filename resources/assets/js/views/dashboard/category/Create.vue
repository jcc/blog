<template>
    <vue-form :title="$t('form.create_category')">
        <div slot="buttons">
            <router-link to="/dashboard/categories" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form-horizontal col-md-6 col-md-offset-3" @submit.prevent="create">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">{{ $t('form.category_name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="path" class="col-sm-2 control-label">{{ $t('form.path') }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="path" id="path" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editor" class="col-sm-2 control-label">{{ $t('form.description') }}</label>
                        <div class="col-sm-10">
                            <textarea id="editor" name="description" placeholder="Please Input Category's Description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">{{ $t('form.create') }}</button>
                        </div>
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
                let formData = new FormData(event.target)

                this.$http.post('/api/category', formData)
                    .then((response) => {
                        toastr.success('You created a new category success!')

                        this.$router.push('/dashboard/categories')
                    }, (response) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

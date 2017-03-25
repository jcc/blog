<template>
    <vue-form :title="$t('form.edit_category')">
        <div slot="buttons">
            <router-link to="/dashboard/categories" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form-horizontal col-md-6 col-md-offset-3" @submit.prevent="edit">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">{{ $t('form.category_name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" v-model="category.name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="path" class="col-sm-2 control-label">{{ $t('form.path') }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="path" id="path" v-model="category.path" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editor" class="col-sm-2 control-label">{{ $t('form.description') }}</label>
                        <div class="col-sm-10">
                            <textarea id="editor" name="description" placeholder="Please Input Category's Description" v-model="category.description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">{{ $t('form.edit') }}</button>
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
        data() {
            return {
                category: {}
            }
        },
        created() {
            this.$http.get('category/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.category = response.data.data
                })
        },
        methods: {
            edit() {
                this.$http.put('category/' + this.$route.params.id, this.category)
                    .then((response) => {
                        toastr.success('You updated the category infomation success!')

                        this.$router.push('/dashboard/categories')
                    }).catch(({response}) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

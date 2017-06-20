<template>
    <div class="row">
        <form class="form-horizontal col-md-6 col-md-offset-3" @submit.prevent="onSubmit">
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
                    <button type="submit" class="btn btn-info">{{ category.id ? $t('form.edit') : $t('form.create') }}</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { stack_error } from 'config/helper'

export default {
    props: {
        category: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    computed: {
        mode() {
            return this.category.id ? 'update' : 'create'
        },
    },
    methods: {
        onSubmit() {
            let url = 'category' + (this.category.id ? '/' + this.category.id : '')
            let method = this.category.id ? 'patch' : 'post'

            this.$http[method](url, this.category)
                .then((response) => {
                    toastr.success('You ' + this.mode + 'd the category success!')

                    this.$router.push('/dashboard/categories')
                }).catch(({response}) => {
                    stack_error(response)
                })
        }
    }
}
</script>
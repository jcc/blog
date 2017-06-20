<template>
    <vue-form :title="$t('form.edit_comment')">
        <div slot="buttons">
            <router-link to="/dashboard/comments" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-10 col-md-offset-1" @submit.prevent="edit">
                    <div class="form-group text-center">
                        <h3>{{ comment.commentable }}</h3>
                        <h6 id="type">{{ (comment.type == 'articles') ? $t('form.articles') : $t('form.discussions') }}</h6>
                    </div>
                    <div class="form-group">
                        <textarea id="editor" name="content"></textarea>
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
import { stack_error } from 'config/helper'
import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'

export default {
    data() {
        return {
            comment: {},
            simplemde: {}
        }
    },
    mounted() {
        this.simplemde = new SimpleMDE({
            element: document.getElementById("editor"),
            placeholder: 'Please input the comment content.',
            autoDownloadFontAwesome: true
        })

        this.$http.get('comment/' + this.$route.params.id + '/edit')
            .then((response) => {
                this.comment = response.data.data
                this.simplemde.value(this.comment.content_raw)
            })
    },
    methods: {
        edit() {
            this.comment.content = this.simplemde.value()

            if (this.comment.content == '') {
                toastr.error('The content is required!')
                return
            }

            this.$http.put('comment/' + this.$route.params.id, this.comment)
                .then((response) => {
                    toastr.success('You updated the comment success!')

                    this.$router.push('/dashboard/comments')
                }).catch(({response}) => {
                    stack_error(response)
                })
        }
    }
}
</script>

<style lang="scss">
    .editor-toolbar.fullscreen {
        z-index: 1000 !important;
    }

    .CodeMirror-fullscreen {
        z-index: 1000 !important;
    }
</style>

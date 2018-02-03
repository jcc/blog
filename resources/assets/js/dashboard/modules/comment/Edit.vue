<template>
  <vue-form :title="$t('form.edit_comment')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.comment' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <div class="row">
        <form class="col-md-10 offset-md-1" @submit.prevent="edit">
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
    </template>
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
    let t = this.$t

    this.simplemde = new SimpleMDE({
      element: document.getElementById("editor"),
      placeholder: t('form.content_placeholder', { type: t('form.comment') }),
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

          this.$router.push({ name: 'dashboard.comment' })
        }).catch(({ response }) => {
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

<template>
  <div class="row">
    <form class="col-sm-9 offset-sm-1" @submit.prevent="onSubmit">
      <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">{{ $t('form.title') }}</label>
        <div class="col-sm-10">
          <input type="text" id="title" name="title" v-model="discussion.title" class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">{{ $t('form.tag') }}</label>
        <div class="col-sm-10">
          <multiselect v-model="tags" :options="allTag" :multiple="true" :searchable="true" :hide-selected="true" :close-on-select="false" :clear-on-select="false" :limit="5" :placeholder="$t('form.select_tag')" label="tag" track-by="tag">
          </multiselect>
        </div>
      </div>
      <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">{{ $t('form.content') }}</label>
        <div class="col-sm-10">
          <textarea id="editor" name="content"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2 col-form-label">
          {{ $t('form.status') }}
        </div>
        <div class="col-sm-2">
          <div class="togglebutton" style="margin-top: 6px">
            <label>
              <input type="checkbox" name="status" value="1" v-model="discussion.status">
              <span class="toggle"></span>
            </label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
          <button type="submit" class="btn btn-info">{{ discussion.id ? $t('form.edit') : $t('form.create') }}</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { stack_error } from 'config/helper'
import { default as SimpleMDE } from 'simplemde/dist/simplemde.min'
import Multiselect from 'vue-multiselect'

export default {
  components: { Multiselect },
  props: {
    discussion: {
      type: Object,
      default () {
        return {}
      }
    }
  },
  data() {
    return {
      simplemde: {},
      tags: null,
      allTag: []
    }
  },
  computed: {
    mode() {
      return this.discussion.id ? 'update' : 'create'
    },
  },
  created() {
    this.loadTags()
  },
  watch: {
    discussion() {
      this.tags = this.discussion.tags.data
      this.simplemde.value(this.discussion.content_raw)
    },
  },
  mounted() {
    let t = this.$t || this.$i18n.t

    this.simplemde = new SimpleMDE({
      element: document.getElementById("editor"),
      placeholder: t('form.content_placeholder', { type: t('form.discussion') }),
      autoDownloadFontAwesome: true
    })
  },
  methods: {
    loadTags() {
      this.$http.get('tags')
        .then((response) => {
          this.allTag = response.data.data
        })
    },
    onSubmit() {
      if (this.tags.length == 0) {
        toastr.error('Tag must select one or more.')
        return;
      }

      let tagIDs = []
      let url = 'discussion' + (this.discussion.id ? '/' + this.discussion.id : '')
      let method = this.discussion.id ? 'patch' : 'post'

      for (var i = 0; i < this.tags.length; i++) {
        tagIDs[i] = this.tags[i].id
      }

      this.discussion.tags = JSON.stringify(tagIDs)
      this.discussion.content = this.simplemde.value()

      this.$http[method](url, this.discussion)
        .then((response) => {
          toastr.success('You ' + this.mode + 'd the discussion success!')

          this.$router.push({ name: 'dashboard.discussion' })
        }).catch(({ response }) => {
          stack_error(response)
        })
    }
  }
}
</script>

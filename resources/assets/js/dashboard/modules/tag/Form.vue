<template>
  <div class="row">
    <form class="col-md-4 offset-md-4" role="form" @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="tag">{{ $t('form.tag') }}</label>
        <input type="text" class="form-control" id="tag" :placeholder="$t('form.tag')" name="tag" v-model="tag.tag" :disabled="(mode == 'udpate' && tag.tag) ? true : false">
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
        <button type="submit" class="btn btn-info">{{ tag.id ? $t('form.edit') : $t('form.create') }}</button>
      </div>
    </form>
  </div>
</template>

<script>
import { stack_error } from 'config/helper'

export default {
  props: {
    tag: {
      type: Object,
      default () {
        return {}
      }
    }
  },
  computed: {
    mode() {
      return this.tag.id ? 'update' : 'create'
    },
  },
  methods: {
    onSubmit() {
      let url = 'tag' + (this.tag.id ? '/' + this.tag.id : '')
      let method = this.tag.id ? 'patch' : 'post'

      this.$http[method](url, this.tag)
        .then((response) => {
          toastr.success('You ' + this.mode + 'd the tag success!')

          this.$router.push({ name: 'dashboard.tag' })
        }).catch(({ response }) => {
          stack_error(response)
        })
    }
  },
}
</script>

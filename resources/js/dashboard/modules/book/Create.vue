<template>
    <vue-form :title="$t('form.create_book')">
        <template slot="buttons">
            <router-link :to="{ name: 'dashboard.book' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}
            </router-link>
        </template>
        <template slot="content">
            <div class="row">
                <form class="col-sm-6 offset-sm-2" @submit.prevent="onSubmit">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">{{ $t('form.isbn') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" v-model="book.name" class="form-control">
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-9">
                            <button type="submit" class="btn btn-info">{{$t('form.create')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </template>

    </vue-form>
</template>

<script>
import BookForm from './Form'

import { stack_error } from 'config/helper'

export default {
  props: {
    category: {
      type: Object,
      default () {
        return {}
      }
    }
  },
  computed: {
    mode() {
      return this.book.id ? 'update' : 'create'
    },
  },
  methods: {
    onSubmit() {
      let url = 'category' + (this.category.id ? '/' + this.category.id : '')
      let method = this.category.id ? 'patch' : 'post'

      this.$http[method](url, this.category)
        .then((response) => {
          toastr.success('You ' + this.mode + 'd the category success!')

          this.$router.push({ name: 'dashboard.category' })
        }).catch(({ response }) => {
          stack_error(response)
        })
    }
  }
}

</script>

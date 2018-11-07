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
                        <label for="isbn13" class="col-sm-3 col-form-label">{{ $t('form.isbn') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="isbn13" id="isbn13" v-model="book.isbn13" class="form-control">
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
    book: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  computed: {
    mode() {
      return 'create'
    }
  },
  methods: {
    onSubmit() {
      let url = 'book'
      let method = 'post'

      this.$http[method](url, this.book)
        .then(response => {
          toastr.success('You ' + this.mode + 'd the book success!')

          this.$router.push({ name: 'dashboard.book' })
        })
        .catch(({ response }) => {
          stack_error(response)
        })
    }
  }
}
</script>

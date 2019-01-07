<template>
  <div class="row">
    <form class="col-sm-4 offset-sm-4" role="form" @submit.prevent="onSubmit" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">{{ $t('form.link_name') }}</label>
        <input type="text" class="form-control" id="name" name="name" :placeholder="$t('form.link_name')" v-model="link.name">
      </div>
      <div class="form-group">
        <label for="link">{{ $t('form.link') }}</label>
        <input type="link" class="form-control" id="link" name="link" :placeholder="$t('form.link')" v-model="link.link">
      </div>
      <div class="form-group">
        <label for="image">{{ $t('form.image') }}</label>
        <div class="upload-box">
          <input type="file" class="form-control" @change="change" id="image" name="image">
          <img v-if="link.image" :src="link.image" :alt="link.name" width="100" height="100" class="img-circle image">
          <i v-else class="fas fa-image link-image"></i>
          <div v-if="link.image" class="mask"><i class="fas fa-cloud-upload-alt"></i></div>
        </div>
      </div>
      <div class="form-group">
        <label>{{ $t('form.is_enable') }}</label>
        <div class="togglebutton" style="margin-top: 6px">
          <label>
            <input type="checkbox" name="status" v-model="link.status">
            <span class="toggle"></span>
          </label>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info">{{ link.id ? $t('form.edit') : $t('form.create') }}</button>
      </div>
    </form>
  </div>
</template>

<script>
import { stack_error } from 'config/helper'

export default {
  props: {
    link: {
      type: Object,
      default () {
        return {
          image: ''
        }
      }
    },
  },
  watch: {
    link() {
      return this.link
    },
  },
  computed: {
    mode() {
      return this.link.id ? 'update' : 'create'
    },
  },
  methods: {
    change(event) {
      const image = event.target.files[0]
      const formData = new FormData()
      formData.append('image', image)
      formData.append('strategy', 'links')

      if (!/\/(?:jpeg|jpg|png)/i.test(image.type)) {
        toastr.error('Uploaded Failed! Image only supported jpeg, jpg and png.');
        return;
      }

      this.$http.post('file/upload', formData)
        .then((response) => {
          this.link.image = response.data.url
        })
    },
    onSubmit() {
      if (!this.link.image) {
        toastr.error('The image is required!')
        return
      }

      let url = 'link' + (this.link.id ? '/' + this.link.id : '')
      let method = this.link.id ? 'patch' : 'post'

      this.$http[method](url, this.link)
        .then((response) => {
          toastr.success('You ' + this.mode + 'd the link information success!')

          this.$router.push({ name: 'dashboard.link' })
        }).catch(({ response }) => {
          stack_error(response)
        })
    }
  },
}
</script>

<style lang="scss" scoped>
.upload-box {
  position: relative;
  width: 100px;
  height: 100px;
}

.link-image {
  display: block;
  width: 100px;
  height: 100px;
  text-align: center;
  font-size: 30px;
  line-height: 100px;
  border: 2px dashed #e7eaec;
  border-radius: 5px;
  color: #e7eaec;
}

.image {
  border-radius: 5px;
}

input#image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100px;
  height: 100px;
  border-radius: 5px;
  cursor: pointer;
  opacity: 0;
  z-index: 10;
}

.mask {
  display: none;
  position: absolute;
  width: 100px;
  height: 100px;
  background-color: rgba(0, 0, 0, 0.5);
  top: 0;
  left: 0;
  border-radius: 5px;
  z-index: 5;
  text-align: center;
  color: rgba(255, 255, 255, .8);
  line-height: 100px;
  font-size: 20px;
}

.upload-box:hover .mask {
  display: block;
}
</style>

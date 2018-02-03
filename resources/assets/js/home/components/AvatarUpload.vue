<template>
  <div class="cover-avatar text-center">
    <img :src="src" class="avatar">
    <a href="javascript:;" class="btn btn-success file">
      <span>{{ $t('form.modify_avatar') }}</span>
      <input type="file" name="avatar" :accept="imageType" @change="upload">
    </a>
    <modal :show="dialogVisible" @cancel="dialogVisible = false">
      <div slot="title">{{ $t('form.crop_avatar') }}</div>
      <cropper :image="cropImage" @canceled="dialogVisible = false" @succeed="succeed"></cropper>
    </modal>
  </div>
</template>

<script>
import Cropper from 'home/components/Cropper'
import Modal from 'dashboard/components/Modal'

export default {
  components: { Modal, Cropper },
  props: {
    src: {
      type: String,
      default () {
        return ''
      }
    }
  },
  data() {
    return {
      cropImage: undefined,
      dialogVisible: false,
      imageType: 'image/png,image/gif,image/jpeg,image/jpg,image/tiff'
    }
  },
  methods: {
    upload(e) {
      let image = e.target.files[0]
      let formData = new FormData()

      formData.append('image', image);
      formData.append('strategy', 'avatar');

      this.$http.post('file/upload', formData)
        .then((response) => {
          this.cropImage = response.data

          this.dialogVisible = true
        })
    },
    succeed() {
      this.dialogVisible = true

      window.location = '/user/profile';
    },
  }
}
</script>

<style lang="scss" scoped>
.file {
  position: relative;
  margin: 0 auto;
  display: block;
  width: 100px;
  height: 30px;
  line-height: 30px;
  font-size: 10px;

  span {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
  }
  input {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    width: 100px;
    height: 30px;
    opacity: 0;
  }
}
</style>

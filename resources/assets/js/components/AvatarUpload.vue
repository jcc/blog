<template>
  <div class="cover-avatar text-center">
    <img :src="image" class="avatar">
    <vue-core-image-upload  
      crop-ratio="1:1" 
      :class="['pure-button','pure-button-primary','js-btn-crop']" 
      :crop="false" 
      url="/user/avatar" 
      :cropBtn="{ok:'保存','cancel':'取消'}"
      extensions="png,gif,jpeg,jpg"
      :headers="csrfToken"
      text="修改头像"
      @imageuploaded="imageuploaded"></vue-core-image-upload>
  </div>
</template>

<script>
  import VueCoreImageUpload  from 'vue-core-image-upload';

  export default {
    components: { VueCoreImageUpload },
    props: {
      src: {
        type: String,
        default() {
          return ''
        }
      }
    },
    data() {
      return {
        image: this.src,
        csrfToken: {
            'X-CSRF-TOKEN': Laravel.csrfToken,
        }
      }
    },
    methods: {
      imageuploaded(res) {
        this.image = res.avatar;
        window.location = '/user/profile'
      }
    }
  }
</script>

<style lang="scss" scoped>
  .pure-button {
    background-color: #1abc9c;
    color: #fff;
    padding: 0.5em 1em;
    border-radius: 5px;
  }
</style>
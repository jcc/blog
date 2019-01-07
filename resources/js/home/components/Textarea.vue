<template>
  <textarea class="form-control" id="content" rows="12" name="content" v-text="content"></textarea>
</template>

<script>
export default {
  props: {
    content: {
      type: String,
      default: null
    }
  }
}
</script>

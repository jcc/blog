<template>
  <div class="row">
    <div class="box box-radius shadow-sm">
      <div class="box-title d-flex justify-content-between align-items-center">
        <h5 class="m-0">{{ title }}</h5>
        <small>
          <slot name="buttons"></slot>
        </small>
      </div>
      <div class="box-content">
        <slot name="content"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default() {
        return null
      }
    }
  }
}
</script>

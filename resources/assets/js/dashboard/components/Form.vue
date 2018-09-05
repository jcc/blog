<template>
  <div class="row">
    <div class="box">
      <div class="box-title">
        <small class="float-right">
          <slot name="buttons"></slot>
        </small>
        <h5>{{ title }}</h5>
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

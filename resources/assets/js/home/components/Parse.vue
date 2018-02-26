<template>
  <div class="markdown" v-html="rawHtml"></div>
</template>

<script>
import emojione from 'emojione'

export default {
  props: {
    content: {
      type: String,
      default () {
        return null
      }
    }
  },
  data() {
    return {
      rawHtml: ''
    }
  },
  created() {
    this.rawHtml = this.parse(this.content)
  },
  methods: {
    parse(content) {
      marked.setOptions({
        highlight: (code) => {
          return hljs.highlightAuto(code).value
        },
        sanitize: true
      })

      return emojione.toImage(marked(content))
    },
  },
}

</script>

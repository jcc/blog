<template>
    <div class="markdown" v-html="rawHtml"></div>
</template>

<script>
import emojione from 'emojione'

export default {
    props: {
        content: {
            type: String,
            default() {
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
        this.rawHtml = emojione.toImage(marked(this.content))
    }
}
</script>
<template>
    <div class="markdown" v-html="rawHtml"></div>
</template>

<script>
    export default {
        props: {
            content: {
                type: Object,
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
            this.rawHtml = marked(this.content.raw)
        }
    }
</script>
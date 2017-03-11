<template>
    <div class="markdown" v-html="rawHtml"></div>
</template>

<script>
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
            this.rawHtml = marked(this.content)
        }
    }
</script>
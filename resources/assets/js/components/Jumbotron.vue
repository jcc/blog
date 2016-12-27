<template>
    <div :class="wrapperClass">
        <div :class="jumbotronClass">
            <div class="row">
                <div :class="colClass">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            wrapperClass: {
                type: String,
                default() {
                    return 'container-fluid'
                }
            },
            jumbotronClass: {
                type: String,
                default() {
                    return 'jumbotron text-center'
                }
            },
            colClass: {
                type: String,
                default() {
                    return 'col-md-10 col-md-offset-1'
                }
            }
        }
    }
</script>

<style scoped>
    .row {
        overflow: hidden;
    }
</style>

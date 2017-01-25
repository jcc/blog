<template>
    <vue-form :title="$t('form.create_discussion')">
        <div slot="buttons">
            <router-link to="/dashboard/discussions" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form-horizontal col-md-9 col-md-offset-1" @submit.prevent="create">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">{{ $t('form.title') }}</label>
                        <div class="col-sm-10">
                            <input type="text" id="title" name="title" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ $t('form.tag') }}</label>
                        <div class="col-sm-10">
                            <multiselect
                                v-model="tags"
                                :options="allTag"
                                :multiple="true"
                                :searchable="true"
                                :hide-selected="true"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :limit="5"
                                :placeholder="$t('form.select_tag')"
                                label="tag"
                                track-by="tag">
                            </multiselect>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">{{ $t('form.content') }}</label>
                        <div class="col-sm-10">
                            <textarea id="editor" name="content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {{ $t('form.status') }}
                        </div>
                        <div class="col-sm-2">
                            <div class="togglebutton" style="margin-top: 6px">
                                <label>
                                    <input type="checkbox" name="status" value="1">
                                    <span class="toggle"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ $t('form.create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
    import Multiselect from 'vue-multiselect'
    import { stack_error } from '../../../config/helper.js'

    export default {
        components: {
            Multiselect
        },
        data() {
            return {
                simplemde: {},
                tags: null,
                allTag: []
            }
        },
        created() {
            this.$http.get('/api/tags')
                .then((response) => {
                    this.allTag = response.data.data
                })
        },
        mounted() {
            this.simplemde = new SimpleMDE({
                element: document.getElementById("editor"),
                placeholder: 'Please input the discussion content.',
                autoDownloadFontAwesome: true
            })
        },
        methods: {
            create(event) {
                if (!this.tags) {
                    toastr.error('Tag must select one or more.')
                    return;
                }

                var formData = new FormData(event.target)

                var tagIDs = []

                for(var i = 0 ; i < this.tags.length ; i++) {
                    tagIDs[i] = this.tags[i].id
                }

                formData.append('content', this.simplemde.value())
                formData.append('tags', JSON.stringify(tagIDs))

                this.$http.post('/api/discussion', formData)
                    .then((response) => {
                        toastr.success('You created a new discussion success!')

                        this.$router.push('/dashboard/discussions')
                    }, (response) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

<style lang="scss">
    .editor-toolbar.fullscreen {
        z-index: 1000 !important;
    }

    .CodeMirror-fullscreen {
        z-index: 1000 !important;
    }
</style>


<template>
    <vue-form :title="$t('form.create_article')">
        <div slot="buttons">
            <router-link to="/dashboard/articles" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form-horizontal col-md-9 col-md-offset-1" @submit.prevent="create">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ $t('form.category') }}</label>
                            <div class="col-sm-10">
                                <multiselect
                                    v-model="selected"
                                    :options="options"
                                    label="name"
                                    track-by="name">
                                </multiselect>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">{{ $t('form.title') }}</label>
                            <div class="col-sm-10">
                                <input type="text" id="title" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="col-sm-2 control-label">{{ $t('form.subtitle') }}</label>
                            <div class="col-sm-10">
                                <input type="text" id="subtitle" name="subtitle" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_image" class="col-sm-2 control-label">{{ $t('form.page_image') }}</label>
                            <div class="col-sm-5">
                                <input type="text" id="page_image" class="form-control" name="page_image" v-model="pageImage" placeholder="ex: /uploads/default_avatar.png">
                            </div>
                            <div class="col-sm-5">
                                <img v-if="pageImage != ''" :src="pageImage" alt="Pig Jian" width="41" height="41">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">{{ $t('form.content') }}</label>
                            <div class="col-sm-10">
                                <textarea id="editor"></textarea>
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
                            <label for="meta_description" class="col-sm-2 control-label">{{ $t('form.meta_description') }}</label>
                            <div class="col-sm-10">
                                <textarea id="meta_description" name="meta_description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ $t('form.datetime') }}</label>
                            <div class="col-sm-10">
                                <date-picker :date="startTime" :option="option"></date-picker>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 control-label">
                                {{ $t('form.is_draft') }}
                            </div>
                            <div class="col-sm-2">
                                <div class="togglebutton" style="margin-top: 6px">
                                    <label>
                                        <input type="checkbox" name="is_draft">
                                        <span class="toggle"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-2 control-label">
                                {{ $t('form.is_original') }}
                            </div>
                            <div class="col-sm-2">
                                <div class="togglebutton" style="margin-top: 6px">
                                    <label>
                                        <input type="checkbox" name="is_original">
                                        <span class="toggle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">{{ $t('form.create') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    import FormMixin from './FormMixin.vue'
    import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
    import Multiselect from 'vue-multiselect'
    import { stack_error } from '../../../config/helper.js'
    import DatePicker from 'vue-datepicker'
    import FineUploader from 'fine-uploader/lib/traditional'

    export default {
        mixins: [FormMixin],
        components: {
            Multiselect,
            DatePicker
        },
        data() {
            return {
                simplemde: '',
                pageImage: ''
            }
        },
        mounted() {
            this.simplemde = new SimpleMDE({
                element: document.getElementById("editor"),
                placeholder: 'Please input the article content.',
                autoDownloadFontAwesome: true
            })

            this.contentUploader()
        },
        methods: {
            create(event) {
                if (!this.tags || !this.selected) {
                    toastr.error('Category and Tag must select one or more.')
                    return;
                }

                var formData = new FormData(event.target)

                var tagIDs = []

                for(var i = 0 ; i < this.tags.length ; i++) {
                    tagIDs[i] = this.tags[i].id
                }

                formData.append('content', this.simplemde.value())
                formData.append('published_at', this.startTime.time)
                formData.append('category_id', this.selected.id)
                formData.append('tags', JSON.stringify(tagIDs))

                this.$http.post('article', formData)
                    .then((response) => {
                        toastr.success('You created a new article success!')

                        this.$router.push('/dashboard/articles')
                    }).catch(({response}) => {
                        stack_error(response.data)
                    })
            },
            contentUploader() {
                let contentUploader = new FineUploader.FineUploaderBasic({
                    paste: {
                        targetElement: document.querySelector(".CodeMirror")
                    },
                    request: {
                        endpoint: '/server/uploads',
                        inputName: 'file',
                        params: {
                            strategy: 'post'
                        }
                    },
                    validation: {
                        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                    },
                    callbacks: {
                        onPasteReceived(file) {
                            let promise = new FineUploader.Promise()

                            console.log(promise)
                            return promise
                        },
                        onError() {
                            console.log('error')
                        }
                    },
                });
                console.log(contentUploader)
            },
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

<template>
    <div class="row">
        <form class="form-horizontal col-md-9 col-md-offset-1" @submit.prevent="onSubmit">
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
                        <input type="text" id="title" name="title" v-model="article.title" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="col-sm-2 control-label">{{ $t('form.subtitle') }}</label>
                    <div class="col-sm-10">
                        <input type="text" id="subtitle" name="subtitle" v-model="article.subtitle" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="page_image" class="col-sm-2 control-label">{{ $t('form.page_image') }}</label>
                    <div class="col-sm-5">
                        <input type="text" id="page_image" class="form-control" name="page_image" v-model="article.page_image" placeholder="ex: /uploads/default_avatar.png">
                    </div>
                    <div class="col-sm-5">
                        <img v-if="article.page_image != null && article.page_image != ''" :src="article.page_image" alt="Pig Jian" width="41" height="41">
                        <div class="cover-upload pull-right">
                            <a href="javascript:;" class="btn btn-success file">
                                <span>{{ $t('form.upload_file') }}</span>
                                <input type="file" @change="coverUploader">
                            </a>
                        </div>
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
                        <textarea id="meta_description" name="meta_description" v-model="article.meta_description" class="form-control"></textarea>
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
                                <input type="checkbox" name="is_draft" v-model="article.is_draft">
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
                                <input type="checkbox" name="is_original" v-model="article.is_original">
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-info">{{ article.id ? $t('form.edit') : $t('form.create') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import FormMixin from './FormMixin'
import { default as SimpleMDE } from 'simplemde/dist/simplemde.min'
import Multiselect from 'vue-multiselect'
import { stack_error } from 'config/helper'
import DatePicker from 'vue-datepicker'
import FineUploader from 'fine-uploader/lib/traditional'

export default {
    mixins: [FormMixin],
    components: {
        Multiselect,
        DatePicker
    },
    props: {
        article: {
            type: Object,
            default() {
                return {
                    page_image: ''
                }
            }
        }
    },
    data() {
        return {
            simplemde: '',
            content: '',
        }
    },
    computed: {
        mode() {
            return this.article.id ? 'update' : 'create'
        },
    },
    watch: {
        article() {
            this.selected = this.article.category.data
            this.tags     = this.article.tags.data
            this.simplemde.value(this.article.content)
            this.startTime.time = this.article.published_time
        }
    },
    mounted() {
        this.simplemde = new SimpleMDE({
            element: document.getElementById("editor"),
            placeholder: 'Please input the article content.',
            autoDownloadFontAwesome: true,
            forceSync: true
        })

        this.contentUploader()
    },
    methods: {
        onSubmit() {
            if (!this.tags || !this.selected) {
                toastr.error('Category and Tag must select one or more.')
                return;
            }

            let tagIDs = []
            let url = 'article' + (this.article.id ? '/' + this.article.id : '')
            let method = this.article.id ? 'patch' : 'post'

            for(var i = 0 ; i < this.tags.length ; i++) {
                tagIDs[i] = this.tags[i].id
            }

            this.article.published_at = this.startTime.time
            this.article.content = this.simplemde.value()
            this.article.category_id = this.selected.id
            this.article.tags = JSON.stringify(tagIDs)

            this.$http[method](url, this.article)
                    .then((response) => {
                        toastr.success('You ' + this.mode + 'd the article success!')

                        this.$router.push('/dashboard/articles')
                    }).catch(({response}) => {
                        stack_error(response)
                    })
        },
        coverUploader(event) {
            let files = event.target.files

            let formData = new FormData()

            formData.append('image', files[0])
            formData.append('strategy', 'cover')

            this.$http.post('file/upload', formData)
                .then((response) => {
                    toastr.success('You upload a file success!')

                    this.article.page_image = response.data.url
                }).catch(({response}) => {
                    if (response.data.error) {
                        toastr.error(response.data.error.message)
                    } else {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    }
                })
        },
        contentUploader() {
            let vm = this

            this.simplemde.codemirror.on('paste', function(editor, event){
              if (event.clipboardData.types.indexOf("Files") >= 0) {
                event.preventDefault()
              }
            })

            let contentUploader = new FineUploader.FineUploaderBasic({
                paste: {
                    targetElement: document.querySelector('.CodeMirror')
                },
                request: {
                    endpoint: '/api/file/upload',
                    inputName: 'image',
                    customHeaders: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    params: {
                      strategy: 'article'
                    }
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                },
                callbacks: {
                    onPasteReceived(file) {
                        let promise = new FineUploader.Promise()

                        if (file == null || typeof file.type == 'undefined' || file.type.indexOf('image/')) {
                            toastr.error('Only can upload image!');
                            return promise.failure('not a image.')
                        }

                        return promise.then(() => {
                            vm.createdImageUploading('image.png')
                        }).success('image')
                    },
                    onComplete(id, name, responseJSON) {
                        vm.replaceImageUploading(name, responseJSON.url)
                    },
                },
            });

            let dragAndDropModule = new FineUploader.DragAndDrop({
              dropZoneElements: [document.querySelector('.CodeMirror')],
              callbacks: {
                processingDroppedFilesComplete(files, dropTarget) {
                  files.forEach((file) => {
                    vm.createdImageUploading(file.name)
                  })
                  contentUploader.addFiles(files); //this submits the dropped files to Fine Uploader
                }
              }
            })
        },
        getImageUploading() {
          return '\n![Uploading ...]()\n'
        },
        createdImageUploading(name) {
            this.simplemde.value(this.simplemde.value() + this.getImageUploading())
        },
        replaceImageUploading(name, url) {
            let result = '\n!['+name+']('+url+')\n'

            this.simplemde.value(this.simplemde.value().replace(this.getImageUploading(), result))
        },
    }
}
</script>

<style lang="scss" scoped>
.cover-upload {
    display: inline-block;

    .file {
        position: relative;
        margin: 0 auto;
        display: block;
        width: 100px;
        height: 41px;
        line-height: 41px;
        font-size: 12px;

        span {
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
        }
        input {
          position: absolute;
          left: 0;
          right: 0;
          top: 0;
          width: 100px;
          height: 30px;
          opacity: 0;
        }
    }
}
</style>
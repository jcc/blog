<template>
    <vue-form :title="$t('form.edit_article')">
        <div slot="buttons">
            <router-link to="/dashboard/articles" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form-horizontal col-md-9 col-md-offset-1" @submit.prevent="edit">
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
                                <img v-if="article.page_image != ''" :src="article.page_image" alt="Pig Jian" width="41" height="41">
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
                                <button type="submit" class="btn btn-info">{{ $t('form.edit') }}</button>
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

    export default {
        mixins: [FormMixin],
        components: {
            Multiselect,
            DatePicker
        },
        data() {
            return {
                article: {},
                simplemde: ''
            }
        },
        created() {
            this.$http.get('/api/article/' + this.$route.params.id + '/edit?include=category,tags')
                .then((response) => {
                    this.article = response.data.data

                    this.selected = this.article.category.data
                    this.tags     = this.article.tags.data
                    this.simplemde.value(this.article.content)
                    this.startTime.time = this.article.published_time
                })
        },
        mounted() {
            this.simplemde = new SimpleMDE({
                element: document.getElementById("editor"),
                placeholder: 'Please input the article content.',
                autoDownloadFontAwesome: true
            })
        },
        methods: {
            edit() {
                if (!this.tags || !this.selected) {
                    toastr.error('Category and Tag must select one or more.')
                    return;
                }

                var tagIDs = []

                for(var i = 0 ; i < this.tags.length ; i++) {
                    tagIDs[i] = this.tags[i].id
                }

                this.article.published_at = this.startTime.time
                this.article.content = this.simplemde.value()
                this.article.category_id = this.selected.id
                this.article.tags = JSON.stringify(tagIDs)

                this.$http.put('/api/article/' + this.$route.params.id, this.article)
                        .then((response) => {
                            toastr.success('You updated the article informations success!')

                            this.$router.push('/dashboard/articles')
                        }, (response) => {
                            stack_error(response.data)
                        })
            }
        }
    }
</script>

<style lang="sass">
    .editor-toolbar.fullscreen {
        z-index: 1000 !important;
    }

    .CodeMirror-fullscreen {
        z-index: 1000 !important;
    }
</style>

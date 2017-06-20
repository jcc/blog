<template>
    <div class="row">
        <div class="ibox">
            <div class="ibox-title">
                <div class="row no-margin">
                    <div class="col-md-6">
                        <h4 class="pull-left">{{ $t('page.files') }}&nbsp;&nbsp;</h4>
                        <div class="pull-left">
                            <ul class="breadcrumb">
                                <li v-for="(disp, path) in upload.breadcrumbs">
                                    <a href="javascript:;" @click="getFileInfo(path)">
                                        {{ disp }}
                                    </a>
                                </li>
                                <li class="active">{{ upload.folderName }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <small class="pull-right" style="margin-top: 7px;">
                            <button type="button" class="btn btn-success btn-md" @click="showFolder = true">
                                <i class="ion-ios-plus"></i> {{ $t('table.new_folder') }}
                            </button>
                            <button type="button" class="btn btn-primary btn-md" @click="showFile = true">
                                <i class="ion-ios-filing-outline"></i> {{ $t('table.upload') }}
                            </button>
                        </small>
                    </div>
                </div>
            </div>
            <div class="ibox-content no-padding">
                <table id="uploads-table" class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th>{{ $t('table.name') }}</th>
                        <th>{{ $t('table.type') }}</th>
                        <th>{{ $t('table.date') }}</th>
                        <th>{{ $t('table.size') }}</th>
                        <th>{{ $t('table.action') }}</th>
                    </tr>

                    <!--Sub Directory-->
                    <tr v-for="(name, path) in upload.subfolders">
                        <td>
                            <a href="javascript:;" @click="getFileInfo(path)">
                                <i class="ion-filing"></i>
                                {{ name }}
                            </a>
                        </td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <button type="button" class="btn btn-danger" @click="deleteFolder(name)">
                                <i class="ion-trash-b"></i>
                            </button>
                        </td>
                    </tr>

                    <!--All Files-->
                    <tr v-for="(file, index) in upload.files">
                        <template v-if="file.type == 'folder'">
                            <td>
                                <a href="javascript:;" @click="getFileInfo(file.fullPath)">
                                    <i class="ion-filing"></i>
                                    {{ file.name }}
                                </a>
                            </td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <button type="button" class="btn btn-danger" @click="deleteFolder(file.fullPath)">
                                    <i class="ion-trash-b"></i>
                                </button>
                            </td>
                        </template>
                        <template v-else>
                            <td>
                                <a target="_blank" :href="file.webPath">
                                    <i class="ion-image" v-if="checkImageType(file.mimeType)"></i>
                                    <i class="ion-document-text" v-else></i>
                                    {{ file.name }}
                                </a>
                            </td>
                            <td>{{ file.mimeType }}</td>
                            <td>{{ file.modified }}</td>
                            <td>{{ file.size }}</td>
                            <td>
                                <button type="button" class="btn btn-info" v-if="checkImageType(file.mimeType)" @click="preview(file.webPath)">
                                    <i class="ion-eye"></i>
                                </button>
                                <button type="button" class="btn btn-danger" @click="deleteFile(file, index)">
                                    <i class="ion-trash-b"></i>
                                </button>
                            </td>
                        </template>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <modal :show="showFolder" @confirm="confirm" @cancel="showFolder = false" show-footer>
            <div slot="title">{{ $t('form.create_folder') }}</div>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="folder" class="control-label col-sm-3">{{ $t('form.folder_name') }}</label>
                    <div class="col-sm-8">
                        <input type="text" id="folder" class="form-control" v-model="folder" :placeholder="$t('form.folder_name')">
                    </div>
                </div>
            </form>
        </modal>
        <modal :show="showFile" @confirm="uploadFile" @cancel="showFile = false" show-footer>
            <div slot="title">{{ $t('form.upload_file') }}</div>
            <form class="form-horizontal" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file" class="control-label col-sm-3">{{ $t('form.file') }}</label>
                    <div class="col-sm-8 file-upload">
                        <button type="button" class="btn btn-primary">{{ $t('table.upload') }}</button>
                        <input type="file" id="file" name="file" @change="change" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="file_name" class="control-label col-sm-3">{{ $t('form.file_name') }}</label>
                    <div class="col-sm-8">
                        <input type="text" id="file_name" class="form-control" name="file_name" v-model="file_name" :placeholder="$t('form.file_name')">
                    </div>
                </div>
            </form>
        </modal>
        <modal :show="showImage" @confirm="confirm" @cancel="showImage = false">
            <div slot="title">{{ $t('form.image') }}</div>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <img :src="preview_image" class="preview-size">
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
import Modal from 'components/dashboard/Modal.vue'

export default {
    components: {
        Modal
    },
    data() {
        return {
            folder: '',
            files: null,
            file_name: '',
            path: '',
            upload: {},
            showFolder: false,
            showFile: false,
            showImage: false,
            preview_image: '',
            fields: [
                {
                    name: 'name',
                    title: 'ID',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'user',
                    title: 'User Name',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'username'
                },
                {
                    name: 'title',
                    title: 'Title'
                },
                {
                    name: "content",
                    title: 'Content',
                    callback: 'content'
                },
                {
                    name: 'status',
                    title: 'Status',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'status'
                },
                {
                    name: 'created_at',
                    title: 'Created At'
                },
                {
                    name: '__actions',
                    dataClass: 'text-center'
                }
            ]
        }
    },
    mounted() {
        this.getFileInfo(this.$route.query.folder)
    },
    methods: {
        preview(path) {
            this.showImage = true
            this.preview_image = path
        },
        confirm() {
            if (!this.folder) {
                toastr.error('The folder name must be required!')
                return
            }

            const path = (this.upload.folder == '/') ? '' : this.upload.folder

            this.path = path + '/' + this.folder

            this.$http.post('folder', { folder: this.path })
                .then((response) => {
                    toastr.success('You create a new folder success!')

                    this.showFolder = false
                    this.$set(this.upload.subfolders, this.path, this.folder)
                    this.folder = ''
                }).catch(({ response }) => {
                    toastr.error(response.status + ' : ' + response.statusText)
                })

        },
        change(event) {
            this.files = event.target.files
        },
        uploadFile() {
            if (!this.files) {
                toastr.error('The file must be required')
                return
            }

            let formData = new FormData()

            formData.append('file', this.files[0])
            formData.append('name', this.file_name)
            formData.append('folder', this.upload.folder)

            this.$http.post('upload', formData)
                .then((response) => {
                    toastr.success('You upload a file success!')

                    let file = {
                        fullPath : response.data.real_path,
                        mimeType : response.data.mime,
                        name : response.data.original_name,
                        size : response.data.size,
                        webPath : response.data.url
                    }

                    this.upload.files.push(file)
                    this.file_name = ''
                    this.showFile = false
                }).catch(({response}) => {
                    if (response.data.error) {
                        toastr.error(response.data.error.message)
                    } else {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    }
                })
        },
        deleteFolder(name) {
            const path = (this.upload.folder == '/') ? '' : this.upload.folder
            this.$http.post('folder/delete', { del_folder: name, folder: this.upload.folder })
                .then((response) => {
                    toastr.success('You delete a folder success!')

                    this.$delete(this.upload.subfolders, path + '/' + name)
                }).catch(({response}) => {
                    if(response.data.error) {
                        toastr.error(response.data.error.http_code + ' : Resource ' + response.data.error.message)
                    } else {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    }
                })
        },
        deleteFile(file, index) {
            this.$http.post('file/delete', { path: file.fullPath })
                .then((response) => {
                    toastr.success('You delete a file success!')

                    this.upload.files.splice(index, 1)
                }).catch(({response}) => {
                    toastr.error(response.status + ' : Resource ' + response.statusText)
                })
        },
        getFileInfo(path) {
            var url = 'upload'

            if (path) {
                url = url + '?folder=' + path
            } else {
                path = '/'
            }

            this.$http.get(url)
                .then((response) => {
                    this.upload = response.data.data
                    if (this.upload.subfolders instanceof Array) {
                        this.upload.subfolders = {}
                    }
                    this.$router.push('/dashboard/files' + '?folder=' + path)
                })
        },
        checkImageType(fileType) {
            if (fileType != null) {
                return fileType.indexOf("image/") != -1
            }

            return false
        }
    }
}
</script>

<style lang="scss" scoped>
.box-body button, .box-body button:hover {
    padding: 0;
    border-radius: 50%;
    width: 2.5em;
    height: 2.5em;
    outline: none;
}
.preview-size {
    max-width: 500px;
}
.file-upload input {
    width: 71px;
    cursor: pointer;
    position: absolute;
    top: 0;
    opacity: 0;
}
</style>

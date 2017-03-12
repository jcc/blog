<template>
    <vue-form :title="$t('form.edit_link')">
        <div slot="buttons">
            <router-link to="/dashboard/links" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <div class="row">
                <form class="form col-md-4 col-md-offset-4" role="form" @submit.prevent="edit" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">{{ $t('form.link_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" :placeholder="$t('form.link_name')" v-model="link.name">
                    </div>
                    <div class="form-group">
                        <label for="link">{{ $t('form.link') }}</label>
                        <input type="link" class="form-control" id="link" name="link" :placeholder="$t('form.link')" v-model="link.link">
                    </div>
                    <div class="form-group">
                        <label for="image">{{ $t('form.image') }}</label>
                        <input type="file" class="form-control" @change="change" id="image" name="image">
                        <img :src="link.image" alt="link.name" width="100" height="100" class="img-circle">
                    </div>
                    <div class="form-group">
                        <label>{{ $t('form.is_enable') }}</label>
                        <div class="togglebutton" style="margin-top: 6px">
                            <label>
                                <input type="checkbox" name="status" v-model="link.status">
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ $t('form.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </vue-form>
</template>

<script>
    import { stack_error } from '../../../config/helper.js'

    export default{
        data(){
            return{
                link: {}
            }
        },
        created() {
            this.$http.get('/api/link/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.link = response.data.data
                })
        },
        methods: {
            change(event) {
                const image = event.target.files[0]
                const formData = new FormData()
                formData.append('id', this.$route.params.id)
                formData.append('image', image)
                formData.append('path', 'links')

                if (!/\/(?:jpeg|jpg|png)/i.test(image.type)) return;

                this.$http.post('/api/upload/path', formData)
                    .then((response) => {
                        this.link.image = response.data.url
                    })
            },
            edit() {
                this.$http.put('/api/link/' + this.$route.params.id, this.link)
                    .then((response) => {
                        toastr.success('You updated the link information success!')

                        this.$router.push('/dashboard/links')
                    }, (response) => {
                        stack_error(response.data)
                    })
            }
        }
    }
</script>

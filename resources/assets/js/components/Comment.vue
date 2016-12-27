<template>
    <div class="container">
        <div class="row comment">
            <div class="col-md-8 col-md-offset-2">
                <h5>{{ title }}</h5>
            </div>
            <div :class="contentWrapperClass">
                <div :class="nullClass" v-if="comments.length == 0">{{ nullText }}</div>
                <div class="media" v-for="(comment, index) in comments" v-else>
                    <div class="media-left">
                        <a :href="'/user/' + comment.username">
                            <img class="media-object img-circle" :src="comment.avatar">
                        </a>
                    </div>
                    <div class="media-body box-body">
                        <div class="heading">
                            <i class="ion-person"></i>{{ comment.username }}
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <i class="ion-clock"></i>{{ comment.created_at }}
                            <span class="pull-right operate">
                                <!-- Favourite Button -->
                                <!-- <a href="javascript:;" @click="like(index)" v-if="username != comment.username"> -->
                                    <!-- <i class="ion-happy-outline" v-if="!comment.like"></i> -->
                                    <!-- <i class="ion-happy" v-else></i> -->
                                    <!-- {{ comment.like_num }} -->
                                <!-- </a> -->
                                <a href="javascript:;" @click="commentDelete(index, comment.id)" v-if="username == comment.username">
                                    <i class="ion-trash-b"></i>
                                </a>
                                <a href="javascript:;" @click="reply(comment.username)"><i class="ion-ios-undo"></i></a>
                            </span>
                        </div>
                        <div class="comment-body markdown" v-html="comment.content_html"></div>
                    </div>
                </div>

                <form class="form-horizontal" style="margin-top: 30px;" @submit.prevent="comment" v-if="canComment">
                    <div class="form-group">
                        <label class="col-sm-2 control-label own-avatar">
                            <a :href="'/user/' + username">
                                <img class="img-circle" :src="userAvatar">
                            </a>
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="content" rows="7" name="content" v-model="content" placeholder="Markdown"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success pull-right">发表评论</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { default as toastr } from 'toastr/build/toastr.min.js'
    import toastrConfig from '../config/toastr'

    export default {
        props: {
            contentWrapperClass: {
                type: String,
                default() {
                    return 'col-md-8 col-md-offset-2'
                }
            },
            title: {
                type: String,
                default() {
                    return ''
                }
            },
            username: {
                type: String,
                default() {
                    return ''
                }
            },
            userAvatar: {
                type: String,
                default() {
                    return ''
                }
            },
            commentableType: {
                type: String,
                default() {
                    return 'articles'
                }
            },
            commentableId: {
                type: String,
                default() {
                    return 0
                }
            },
            canComment: {
                type: Boolean,
                default() {
                    return false
                }
            },
            nullText: {
                type: String,
                default() {
                    return 'Nothing...'
                }
            },
            nullClass: {
                type: String,
                default() {
                    return 'none'
                }
            }
        },
        data() {
            return {
                comments: [],
                content: ''
            }
        },
        mounted() {
            var url = '/api/commentable/' + this.commentableId + '/comment'
            this.$http.get(url, {
                params: {
                    commentable_type: this.commentableType
                }
            }).then((response) => {
                response.data.data.forEach((data) => {
                    data.content_html = this.parse(data.content_raw)

                    return data
                })
                this.comments = response.data.data
            })

            toastr.options = toastrConfig
        },
        methods: {
            comment() {
                const data = {
                    content: this.content,
                    commentable_id: this.commentableId,
                    commentable_type: this.commentableType
                }

                this.$http.post('/api/comments', data)
                    .then((response) => {
                        let comment = null
                        comment = response.data.data
                        comment.content_html = this.parse(comment.content_raw)
                        this.comments.push(comment)
                        this.content = ''
                        toastr.success('You publish the comment success!')
                    })
            },
            reply(name) {
                $('#content').focus()
                this.content = '@' + name + ' '
            },
            // like(index) {
            //     this.comments[index].like = !this.comments[index].like
            //     this.comments[index].like ? this.comments[index].like_num++ : this.comments[index].like_num--
            // },
            commentDelete(index, id) {
                this.$http.delete('/api/comments/' + id)
                    .then((response) => {
                        this.comments.splice(index, 1)
                        toastr.success('You delete your comment success!')
                    })
            },
            parse(html) {
                marked.setOptions({
                    highlight: (code) => {
                      return hljs.highlightAuto(code).value
                    }
                })

                return marked(html)
            }
        }
    }
</script>

<style scoped>
    i {
        margin-right: 5px;
    }
    .operate {
        font-size: 16px;
    }
    .operate a {
        margin-right: 5px;
        text-decoration: none;
    }
    .none {
        color: #c5c5c5;
        font-size: 16px;
    }
    .comment .img-circle {
        width: 64px;
        height: 64px;
        -webkit-transition: transition .6s ease-in;
        -moz-transition: transition .6s ease-in;
        transition: transform .6s ease-in;
    }
    .comment .media-left:hover img, .media-right:hover img{
        -webkit-transform: rotateZ(360deg);
        -moz-transform: rotateZ(360deg);
        transform: rotateZ(360deg);
    }
    .comment .media {
        padding-top: 20px;
    }
    @media screen and (max-width: 767px) {
        .comment .media-left {
            display: none;
        }
        .own-avatar {
            display: none;
        }
    }
    .comment .box-body {
        border: 1px solid #ECF0F1;
        border-radius: 5px;
        background-color: #fff;
        color: #7F8C8D;
    }
    .comment .heading {
        padding: 10px 20px;
        background: #ECF0F1;
    }
    .comment-body {
        padding: 30px 50px;
        color: #34495e;
    }
    .comment-body a {
        color: #1abc9c;
    }
    .comment .comment-editor {
        margin-top: 40px;
    }
    .comment .footing {
        padding: 10px 20px;
        border-top: 1px dashed #e1e1e1;
    }
</style>
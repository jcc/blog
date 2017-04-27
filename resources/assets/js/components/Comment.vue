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
                            <i class="ion-person"></i><a :href="'/user/' + comment.username">{{ comment.username }}</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <i class="ion-clock"></i>{{ comment.created_at }}
                            <span class="pull-right operate">
                                <b :class="comment.vote_count > 0 ? 'text-success' : 'text-danger'">{{ comment.vote_count == 0 ? '' : comment.vote_count }}</b>
                                <template v-if="username != comment.username">
                                    <a 
                                    :title="comment.is_up_voted ? 'Cancel vote' : 'Up vote'" 
                                    :data-tooltip-text="comment.is_up_voted ? 'Cancel vote' : 'Up vote'" 
                                    :href="canComment ? 'javascript:;' : '/login'" 
                                    :disabled="isLike ? 'true' : 'false'" 
                                    @click="upVote(index)"> 
                                        <i :class="comment.is_up_voted ? 'rating-button ion-arrow-up-a text-success' : 'rating-button ion-arrow-up-a'"></i>
                                    </a>
                                    <a 
                                    :title="comment.is_down_voted ? 'Cancel vote' : 'Down vote'" 
                                    :data-tooltip-text="comment.is_down_voted ? 'Cancel vote' : 'Down vote'" 
                                    :href="canComment ? 'javascript:;' : '/login'" 
                                    :disabled="isLike ? 'true' : 'false'" 
                                    @click="downVote(index)"> 
                                        <i :class="comment.is_down_voted ? 'rating-button ion-arrow-down-a text-danger' : 'rating-button ion-arrow-down-a'"></i>
                                    </a>
                                </template>
                                <a href="javascript:;" @click="commentDelete(index, comment.id)" v-if="username == comment.username">
                                    <i class="ion-trash-b"></i>
                                </a>
                                <a href="javascript:;" @click="reply(comment.username)"><i class="ion-ios-undo"></i></a>
                            </span>
                        </div>
                        <template v-if="comment.vote_count < 0">
                            <div :class="'comment-body markdown downvoted ' + downVotedClass(comment.vote_count)" v-html="comment.content_html"></div>
                        </template>
                        <template v-else>
                            <div :class="'comment-body markdown'" v-html="comment.content_html"></div>
                        </template>
                        
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
                            <button type="submit" :disabled="isSubmiting ? true : false" class="btn btn-success pull-right">{{ $t('form.submit_comment') }}</button>
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
import emojione from 'emojione'
import FineUploader from 'fine-uploader/lib/traditional'
import { stack_error } from '../config/helper'

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
            content: '',
            isSubmiting: false,
	    isLike: false
        }
    },
    mounted() {
        var url = 'commentable/' + this.commentableId + '/comment'
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

        this.contentUploader()
    },
    methods: {
        comment() {
            const data = {
                content: this.content,
                commentable_id: this.commentableId,
                commentable_type: this.commentableType
            }

            this.isSubmiting = true

            this.$http.post('comments', data)
                .then((response) => {
                    let comment = null

                    comment = response.data.data
                    comment.content_html = this.parse(comment.content_raw)

                    this.comments.push(comment)
                    this.content = ''
                    this.isSubmiting = false

                    toastr.success('You publish the comment success!')
                }).catch(({response}) => {
                    this.isSubmiting = false
                    stack_error(response.data)
                })
        },
        reply(name) {
            $('#content').focus()
            this.content = '@' + name + ' '
        },
    	downVotedClass(votes){
    		votes = votes > 0 ? 0 : votes > 5 ? 5 : votes*-1
                    
    		var downVoteClass = 'downvoted' + votes
                    
    		return downVoteClass
    	},
        upVote(index) {
            this.isLike = true
            this.$http.post('comments/upvote', { id: this.comments[index].id })
                .then((response) => {
                    if(this.comments[index].is_up_voted){
                        this.comments[index].vote_count--
                        this.comments[index].is_voted = false
                        this.comments[index].is_down_voted = false
                        this.comments[index].is_up_voted = false
                    }
                    else if(this.comments[index].is_down_voted){
                        this.comments[index].vote_count = this.comments[index].vote_count + 2
                        this.comments[index].is_voted = true
                        this.comments[index].is_up_voted = true
                        this.comments[index].is_down_voted = false
                    }
                    else{
                        this.comments[index].vote_count++
                        this.comments[index].is_voted = true
                        this.comments[index].is_up_voted = true
                        this.comments[index].is_down_voted = false
                    }
                    this.isLike = false
                }).catch(({response}) => {
                	this.isLike = false
                	stack_error(response.data)
                })
        },
        downVote(index) {
            this.isLike = true
            this.$http.post('comments/downvote', { id: this.comments[index].id })
                .then((response) => {
                    if(this.comments[index].is_down_voted){
                        this.comments[index].vote_count++
                        this.comments[index].is_voted = false
                        this.comments[index].is_down_voted = false
                        this.comments[index].is_up_voted = false
                    }
                    else if(this.comments[index].is_up_voted){
                        this.comments[index].vote_count = this.comments[index].vote_count - 2
                        this.comments[index].is_voted = true
                        this.comments[index].is_down_voted = true
                        this.comments[index].is_up_voted = false
                    }
                    else{
                        this.comments[index].vote_count--
                        this.comments[index].is_voted = true
                        this.comments[index].is_down_voted = true
                        this.comments[index].is_up_voted = false
                    }
                    this.isLike = false
                }).catch(({response}) => {
                	this.isLike = false
                	stack_error(response.data)
                })
        },
        commentDelete(index, id) {
            this.$http.delete('comments/' + id)
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

            return emojione.toImage(marked(html))
        },
        contentUploader() {
            let vm = this

            document.getElementById("content").addEventListener('paste', function(e) {
                if (event.clipboardData.types.indexOf("Files") >= 0) {
                  event.preventDefault()
                }
            }, false);

            let uploader = new FineUploader.FineUploaderBasic({
                paste: {
                    targetElement: document.querySelector('#content')
                },
                request: {
                    endpoint: '/api/file/upload',
                    inputName: 'image',
                    customHeaders: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    params: {
                      strategy: 'comment'
                    }
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                },
                callbacks: {
                    onPasteReceived(file) {

                        console.log('success')
                        let promise = new FineUploader.Promise()

                        if (file == null || typeof file.type == 'undefined' || file.type.indexOf('image/')) {
                            toastr.error('Only can upload image!');
                            return promise.failure('not a image.')
                        }

                        if (!/\/(?:jpeg|jpg|png|gif)/i.test(file.type)) {
                            toastr.error('Uploaded Failed! Image only supported jpeg, jpg, gif and png.');
                            return promise.failure('not a image.')
                        }

                        return promise.then(() => {
                            vm.createdImageUploading('image.png')
                        }).success('image')
                    },
                    onComplete(id, name, responseJSON) {
                        vm.replaceImageUploading(name, responseJSON.url)
                    },
                    onError() {
                        toastr.error('Uploaded Failed!');
                        vm.replaceImageUploading(name, '')
                    }
                },
            });

            let dragAndDropModule = new FineUploader.DragAndDrop({
              dropZoneElements: [document.querySelector('#content')],
              callbacks: {
                processingDroppedFilesComplete(files, dropTarget) {
                    files.forEach((file) => {
                        if (!/\/(?:jpeg|jpg|png|gif)/i.test(file.type)) {
                            toastr.error('Uploaded Failed! Image only supported jpeg, jpg, gif and png.');
                            return promise.failure('not a image.')
                        }
                        vm.createdImageUploading(file.name)
                    })
                    uploader.addFiles(files); //this submits the dropped files to Fine Uploader
                }
              }
            })
        },
        getImageUploading() {
          return '\n![Uploading ...]()\n'
        },
        createdImageUploading(name) {
            this.content = this.content + this.getImageUploading()
        },
        replaceImageUploading(name, url) {
            let result = ''

            if (url) {
              result = '\n!['+name+']('+url+')\n'
            }

            this.content = this.content.replace(this.getImageUploading(), result)
        },
    }
}
</script>

<style lang="scss" scoped>
i {
    margin-right: 5px;
}
    .operate {
        font-size: 16px;
        a {
            margin-right: 5px;
            text-decoration: none;
        }
        b{
            margin-right: 5px;
        }
    }
    .rating-button{
        margin-right: -4px;
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

    a {
        color: #7F8C8D;
    }
}
.comment-body {
    padding: 30px 50px;
    color: #34495e;

    a {
        color: #1abc9c;
    }
}
.comment .comment-editor {
    margin-top: 40px;
}
.comment .footing {
    padding: 10px 20px;
    border-top: 1px dashed #e1e1e1;
}
.comment .downvoted5 {
  background: #fff;
  opacity: .1;
}

.comment .downvoted4 {
  background: #fff;
  opacity: .2;
}

.comment .downvoted3 {
  background: #fff;
  opacity: .4;
}

.comment .downvoted2 {
  background: #fff;
  opacity: .5;
}

.comment .downvoted1 {
  background: #fff;
  opacity: .6;
}

.comment .downvoted:hover {
  opacity: 1;
}
</style>
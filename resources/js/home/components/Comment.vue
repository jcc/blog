<template>
  <div class="container">
    <div class="row comment">
      <div class="col-md-8 offset-md-2">
        <h5>{{ title }}</h5>
        <div :class="nullClass" v-if="comments.length == this.commentsCount" class="heading">
          <a href="javascript:;" @click="commentLoad()">
            <i   class="fas fa-plus">&nbsp;&nbsp;&nbsp;&nbsp; load more comments</i>
          </a>
        </div>        
      </div>
      <div :class="contentWrapperClass">
        <div :class="nullClass" v-if="comments.length == 0">{{ nullText }}</div>
        <div class="media" v-for="(comment, index) in comments" v-else  >
          <div class="media-left mr-3">
            <a :href="'/user/' + comment.username">
              <img class="media-object rounded-circle" :src="comment.avatar">
            </a>
          </div>
          <div class="media-body box-body">
            <div class="heading">
              <i class="fas fa-user"></i><a :href="'/user/' + comment.username">{{ comment.username }}</a> &nbsp;&nbsp;&nbsp;&nbsp;
              <i class="fas fa-clock"></i>{{ comment.created_at }}
              <span class="float-right operate">
                <vote-button v-if="username != comment.username" :item="comment"></vote-button>
                <a href="javascript:;" @click="commentDelete(index, comment.id)" v-if="username == comment.username">
                  <i class="fas fa-trash-alt"></i>
                </a>
                <a href="javascript:;" @click="reply(comment.username)"><i class="fas fa-share"></i></a>
              </span>
            </div>
            <div class="comment-body markdown" :class="comment.is_down_voted ? 'downvoted' : ''" v-html="comment.content_html"></div>
          </div>
        </div>
        <form class="form mt-4" style="margin-top: 30px;" @submit.prevent="comment" v-if="canComment">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label own-avatar">
              <a :href="'/user/' + username">
                <img width="60" class="rounded-circle" :src="userAvatar">
              </a>
            </label>
            <div class="col-sm-10">
              <text-complete id="content" area-class="form-control" v-model="content" placeholder="Markdown" :rows="7" :strategies="strategies"></text-complete>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12">
              <button type="submit" :disabled="isSubmiting ? true : false" class="btn btn-success float-right">{{ $t('form.submit_comment') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { default as toastr } from 'toastr/build/toastr.min.js'
import toastrConfig from 'config/toastr'
import emojione from 'emojione'
import FineUploader from 'fine-uploader/lib/traditional'
import { stack_error } from 'config/helper'
import VoteButton from 'home/components/VoteButton'
import TextComplete from 'v-textcomplete'
import { default as githubEmoji } from 'vendor/github_emoji'

export default {
  components: { VoteButton, TextComplete },
  props: {
    contentWrapperClass: {
      type: String,
      default () {
        return 'col-md-8 offset-md-2'
      }
    },
    title: {
      type: String,
      default () {
        return ''
      }
    },
    username: {
      type: String,
      default () {
        return ''
      }
    },
    userAvatar: {
      type: String,
      default () {
        return ''
      }
    },
    commentableType: {
      type: String,
      default () {
        return 'articles'
      }
    },
    commentableId: {
      type: String,
      default () {
        return 0
      }
    },
    canComment: {
      type: Boolean,
      default () {
        return false
      }
    },
    nullText: {
      type: String,
      default () {
        return 'Nothing...'
      }
    },
    nullClass: {
      type: String,
      default () {
        return 'none'
      }
    }
  },
  data() {
    return {
      comments: [],
      commentsCount:1,
      content: '',
      isSubmiting: false,
      strategies: [{
        match: /(^|\s):([a-z0-9+\-\_]*)$/,
        search(term, callback) {
          callback(Object.keys(githubEmoji).filter(function(name) {
            return name.startsWith(term);
          }).slice(0, 10))
        },
        template(name) {
          return '<img width="17" src="' + githubEmoji[name] + '"></img> ' + name;
        },
        replace(value) {
          return '$1:' + value + ': '
        },
      }],
    }
  },
  mounted() {
    var url = 'commentable/' + this.commentableId + '/comment'
    this.$http.get(url, {
      params: {
        commentable_type: this.commentableType,
        commentsCount:this.commentsCount
      }
    }).then((response) => {
      response.data.data.forEach((data) => {
        data.content_html = this.parse(data.content_raw)

        return data
      })
      this.comments = response.data.data
    })

    toastr.options = toastrConfig

    if (this.canComment) {
      this.contentUploader()
    }
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
        }).catch(({ response }) => {
          this.isSubmiting = false
          stack_error(response)
        })
    },
    reply(name) {
      $('#content').focus()
      this.content = '@' + name + ' '
    },
    commentDelete(index, id) {
      this.$http.delete('comments/' + id)
        .then((response) => {
          this.comments.splice(index, 1)
          toastr.success('You delete your comment success!')
        })
    },
    commentLoad() {
      var url = 'commentable/' + this.commentableId + '/comment'
      this.$http.get(url, {
        params: {
          commentable_type: this.commentableType,
          commentsCount:this.commentsCount+1
        }
      }).then((response) => {
        response.data.data.forEach((data) => {
          data.content_html = this.parse(data.content_raw)
          return data
        })
        this.comments = response.data.data
        this.commentsCount +=1
        
      }).then((response)=>{
        console.log(this.commentsCount)
      })

      toastr.options = toastrConfig

      if (this.canComment) {
        this.contentUploader()
      }
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
        result = '\n![' + name + '](' + url + ')\n'
      }

      this.content = this.content.replace(this.getImageUploading(), result)
    },
  }
}
</script>
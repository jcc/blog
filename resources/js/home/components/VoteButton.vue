<template>
  <span class="vote-button">
    <a href="javascript:;" @click="upVote(item.id)">
      <i :class="item.is_up_voted ? 'fas fa-thumbs-up text-success' : 'far fa-thumbs-up'"></i>
      <small v-if="item.vote_count > 0">{{ item.vote_count }}</small>
    </a>
    <a href="javascript:;" @click="downVote(item.id)">
      <i :class="item.is_down_voted ? 'fas fa-thumbs-down text-danger' : 'far fa-thumbs-down'"></i>
    </a>
  </span>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      default () {
        return {}
      }
    },
    api: {
      type: String,
      default: 'comments'
    },
  },
  data() {
    return {
      isLike: false,
    }
  },
  methods: {
    toggleStatus() {
      let count = this.item.vote_count

      this.item.is_voting = !this.item.is_voting

      this.item.vote_count = this.item.is_voting ? count + 1 : count - 1
    },
    upVote(id) {
      this.toggleVote(id, 'up')
    },
    downVote(id) {
      this.toggleVote(id, 'down')
    },
    toggleVote(id, type) {
      let url = this.api + '/vote/' + type
      let upType = 'is_up_voted'
      let downType = 'is_down_voted'
      let checkType = type == 'up' ? downType : upType
      let votingType = type == 'up' ? upType : downType

      this.$http.post(url, { id: id })
        .then(() => {
          if (this.item[checkType]) {
            this.item[upType] = !this.item[upType]
            this.item[downType] = !this.item[downType]
            type == 'up' ? this.item.vote_count++ : this.item.vote_count--
          } else {
            this.item[votingType] = !this.item[votingType]
            if (type == 'up') this.item[upType] ? this.item.vote_count++ : this.item.vote_count--
          }
        }).catch((response) => {
          if (response.status == 401) {
            window.location = '/login';
          }
        })
    },
  }
}
</script>

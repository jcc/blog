<template>
  <transition v-if="show" name="modal">
    <div class="modal" @click.self="clickMask">
      <div class="modal-dialog" :class="modalClass">
        <div class="modal-content">

          <div class="modal-header">
            <slot name="header">
              <h4 class="modal-title">
                <slot name="title">
                  {{title}}
                </slot>
              </h4>
              <a class="close" @click="cancel"><i class="fas fa-times-circle"></i></a>
            </slot>
          </div>

            <div class="modal-body">
              <slot></slot>
            </div>

            <div class="modal-footer" v-if="showFooter">
              <slot name="footer">
                <button type="button" :class="cancelClass" @click="cancel">{{cancelText}}</button>
                <button type="button" :class="confirmClass" @click="confirm">{{confirmText}}</button>
              </slot>
            </div>

        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: 'Modal'
    },
    small: {
      type: Boolean,
      default: false
    },
    large: {
      type: Boolean,
      default: false
    },
    full: {
      type: Boolean,
      default: false
    },
    force: {
      type: Boolean,
      default: false
    },
    confirmText: {
      type: String,
      default: 'OK'
    },
    cancelText: {
      type: String,
      default: 'Cancel'
    },
    confirmClass: {
      type: String,
      default: 'btn btn-info'
    },
    cancelClass: {
      type: String,
      default: 'btn btn-light'
    },
    closeWhenConfirm: {
      type: Boolean,
      default: false
    },
    showFooter: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      duration: null
    };
  },
  computed: {
    modalClass () {
      return {
        'modal-lg': this.large,
        'modal-sm': this.small,
        'modal-full': this.full
      }
    }
  },
  created () {
    if (this.show) {
      document.body.className += ' modal-open';
    }
  },
  beforeDestroy () {
    document.body.className = document.body.className.replace(/\s?modal-open/, '');
  },
  watch: {
    show (value) {
      if (value) {
        document.body.className += ' modal-open';
      } else {
        if (!this.duration) {
          this.duration = window.getComputedStyle(this.$el)['transition-duration'].replace('s', '') * 1000;
        }
        window.setTimeout(() => {
          document.body.className = document.body.className.replace(/\s?modal-open/, '');
        }, this.duration || 0);
      }
    }
  },
  methods: {
    confirm () {
      this.$emit('confirm');
    },
    cancel () {
      this.$emit('cancel');
    },
    clickMask () {
      if (!this.force) {
        this.cancel();
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.modal {
  display: block;
  background-color: rgba(0, 0, 0, .5);
  transition: opacity .3s ease;
}
.modal-header {
  padding-bottom: 25px;
  border: none;
}
.modal-dialog {
  vertical-align: middle;
  margin: 30px auto;
}
.modal-content {
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
.modal-enter .modal-content,
.modal-leave-active .modal-content {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>

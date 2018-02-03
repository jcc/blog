<template>
  <span :style="{color: color}" @click="setStatus(rowData)"><i class="fas fa-circle"></i></span>
</template>

<script>
export default{
  props: {
    rowData: {
      type: Object,
      required: true
    },
    apiUrl: {
      type: String,
      required: true
    }
  },
  computed: {
    color() {
      return this.rowData.status ? '#8eb4cb' : '#bf5329'
    }
  },
  methods: {
    setStatus(rowData) {
      let index = this
      swal({
        title: "Change the record status",
        text: "The action may affect some data, Please think twice!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, changed it!",
      }).then(function (result) {
        result.value && index.postData(rowData)
      })
    },
    postData(rowData) {
      this.$http.post(this.apiUrl + '/' + rowData.id + '/status', {status: !rowData.status})
          .then((response) => {
            this.rowData.status = !this.rowData.status
            if (this.rowData.status) {
              toastr.success('You changed a record of the status success!')
            } else {
              toastr.warning('You changed a record of the status, Please check again!')
            }
          }).catch((response) => {
            if (response.data.error) {
              toastr.error(response.data.error.message)
            } else {
              toastr.error(response.status + ' : Resource ' + response.statusText)
            }
          })
    }
  }
}
</script>

<style lang="scss" scoped>
span {
  cursor:pointer;
}
</style>

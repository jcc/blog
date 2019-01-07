<template>
  <div class="wrapper">
    <div class="row pt-3">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box box-radius shadow-sm">
          <div class="box-title">
            <span class="badge badge-success float-right">{{ $t('page.all') }}</span>
            <h5 class="m-0">{{ $t('page.user_num') }}</h5>
          </div>
          <div class="box-content">
            <h1 class="m-0"><i class="fas fa-users"></i>{{ statistics.users }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box box-radius shadow-sm">
          <div class="box-title">
            <span class="badge badge-success float-right">{{ $t('page.all') }}</span>
            <h5 class="m-0">{{ $t('page.view_num') }}</h5>
          </div>
          <div class="box-content">
            <h1 class="m-0"><i class="fas fa-eye"></i>{{ statistics.visitors }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box box-radius shadow-sm">
          <div class="box-title">
            <span class="badge badge-success float-right">{{ $t('page.all') }}</span>
            <h5 class="m-0">{{ $t('page.article_num') }}</h5>
          </div>
          <div class="box-content">
            <h1 class="m-0"><i class="fas fa-newspaper"></i>{{ statistics.articles }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="box box-radius shadow-sm">
          <div class="box-title">
            <span class="badge badge-success float-right">{{ $t('page.all') }}</span>
            <h5 class="m-0">{{ $t('page.comment_num') }}</h5>
          </div>
          <div class="box-content">
            <h1 class="m-0"><i class="fas fa-comments"></i>{{ statistics.comments }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from 'home/components/Chartjs.vue'

export default {
  components: {
    Chart
  },
  data() {
    return {
      statistics: {}
    }
  },
  mounted() {
    this.$http.get('statistics')
      .then((response) => {
        this.statistics = response.data
      })
  }
}
</script>

<style lang="scss" scoped>
h1 {
  font-size: 30px;
  font-weight: normal;
}

h5 {
  font-size: 14px;
}

h1 i {
  font-size: 35px;
  margin-right: 12px;
}

.label {
  padding: .3em .6em;
}
</style>

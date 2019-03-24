<template>
  <canvas class="chartjs" :width="width" :height="height"></canvas>
</template>

<script>
import Chart from 'chart.js/dist/Chart'

const types = ['line', 'bar', 'radar', 'polarArea', 'pie', 'doughnut']

export default {
  props: {
    width: Number,
    height: Number,
    type: {
      type: String,
      required: true,
      validator(value) {
        return types.indexOf(value) > -1
      }
    },
    data: {
      type: Object,
      required: true,
      default: () => ({})
    },
    options: {
      type: Object,
      default: () => ({})
    }
  },
  mounted() {
    this.chart = new Chart(this.$el, {
      type: this.type,
      data: this.data,
      options: this.options
    })
  },
  data() {
    return {
      chart: null
    }
  },
  watch: {
    data(val) {
      this.$nextTick(() => {
        // this.chart.data.datasets = val.datasets
        // this.chart.data.labels = val.labels
        this.chart.update()
      })
    }
  }
}
</script>

<style>
canvas.chartjs {
  max-width: 100%;
}
</style>

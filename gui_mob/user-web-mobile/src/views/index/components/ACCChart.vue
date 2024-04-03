<template>
  <div :class="className" style="width: 100%; height: 300px"></div>
</template>

<script>
import echarts from "echarts";
import axios from "axios";
export default {
  name: "ACCChart",
  props: {
    className: {
      type: String,
      default: "chart",
    },
    path: {
      type: String,
      default: "",
    },
    minDateTime: {
      type: String,
      default: "",
    },
    maxDateTime: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      chart: null,
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.initChart();
    });
  },
  beforeDestroy() {
    if (!this.chart) {
      return;
    }
    this.chart.dispose();
    this.chart = null;
  },
  methods: {
    initChart() {
      this.chart = echarts.init(this.$el, "macarons");
      this.getData();
    },
    getData() {
      axios.get(this.path + "/ACC.json").then((response) => {
        if (response.status == 200) {
          this.setOptions(response.data);
        }
      });
    },
    setOptions(chartData) {
      chartData = chartData.map(item => item[0]);

      const minTime = new Date(this.minDateTime).getTime();
      const maxTime = new Date(this.maxDateTime).getTime();
      const frequency = (maxTime - minTime) / chartData.length;

      const jsonArray = [];
      chartData.forEach((item, index) => {
        jsonArray.push([new Date(minTime + index * frequency), item]);
      });

      const option = {
        title: {
          text: "ACC",
        },
        animation: false,
        tooltip: {
          trigger: "axis",
          axisPointer: {
            type: "cross",
          },
          padding: [5, 10],
        },
        grid: {
          top: 50,
          left: 50,
          right: 50,
          bottom: 50,
        },
        xAxis: {
          type: "time",
          interval: 1000 * 60 * 2,
          axisLabel: {
            // https://echarts.apache.org/zh/option.html#xAxis.axisLabel.formatter
            // formatter: '{HH}:{mm}'
            formatter: function (value, index) {
              const date = new Date(value);
              const hours = date.getHours();
              const minutes = date.getMinutes();
              const seconds = date.getSeconds();

              return (
                (hours >= 10 ? hours : `0${hours}`) +
                ":" +
                (minutes >= 10 ? minutes : `0${minutes}`) +
                ":" +
                (seconds >= 10 ? seconds : `0${seconds}`)
              );
            },
          },
        },
        yAxis: {
          type: "value",
          splitNumber: 5,
        },
        series: [
          {
            name: "ACC",
            itemStyle: {
              normal: {
                lineStyle: {
                  color: "#A091B2",
                  width: 2,
                },
              },
            },
            type: "line",
            showSymbol: false,
            data: jsonArray,
            // smooth: false
          },
        ],
      };
      this.chart.setOption(option);
    },
  },
};
</script>

<style>
</style>
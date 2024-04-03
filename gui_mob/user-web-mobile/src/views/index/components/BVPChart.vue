<template>
  <div :class="className" style="width: 100%; height: 300px"></div>
</template>

<script>
import echarts from "echarts";
import axios from "axios";
export default {
  name: "BVPChart",
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
    }
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
      axios.get(this.path + "/BVP.json").then((response) => {
        if (response.status == 200) {
          this.setOptions(response.data);
        }
      });
    },
    setOptions(chartData) {
      console.log("BVP数据长度", chartData.length);
      // 数据频率
      const minTime = new Date(this.minDateTime).getTime();
      const maxTime = new Date(this.maxDateTime).getTime();
      // const frequency = (121 * 1000) / dataArray.length;
      const frequency = (maxTime - minTime) / chartData.length;
      console.log("BVP计算频率", frequency);

      // let timestamp = new Date("2022-01-01 08:00:00:000").getTime();
      // console.log(echarts.format.formatTime('yyyy-MM-dd hh:mm:ss:SSS', 1640995200020))
      const jsonArray = [];
      chartData.forEach((item, index) => {
        jsonArray.push([
          new Date(minTime + index * frequency),
          // new Date(
          //   echarts.format.formatTime(
          //     "yyyy-MM-dd hh:mm:ss:SSS",
          //     timestamp + index * frequency
          //   )
          // ),
          // new Date(timestamp + index * frequency).format("yyyy-MM-dd hh:mm:ss:"),
          item,
        ]);
      });

      const option = {
        title: {
          text: "BVP",
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
          // min: "2022-01-01 08:00:00",
          // max: "2022-01-01 08:11:00",
          // interval: function(index, value) {
          //   console.log
          //   // interval
          //   return false;
          // },
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
          // axisTick: {
          //   show: true,
          // },
          // data: timeData,
          // boundaryGap: false,
          // splitNumber: timeString.length
        },
        yAxis: {
          type: "value",
          // axisTick: {
          //   show: false,
          // },
          splitNumber: 5,
        },
        series: [
          {
            name: "BVP",
            itemStyle: {
              normal: {
                lineStyle: {
                  color: "#AA4744",
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
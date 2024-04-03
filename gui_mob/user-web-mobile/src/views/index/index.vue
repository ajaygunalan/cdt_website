<template>
  <div>
    <div class="header">
      <div class="title">User | Welcome to CDT</div>
      <div class="logout" @click="clickLogout">Logout</div>
    </div>
    <div style="height: 50px"></div>

    <div class="container">
      <div class="user-con">
        <div class="user">
          <img class="avatar" src="@/assets/images/user.png" />

          <div class="right">
            <div class="name text-cut">
              {{ userInfo.surname }} {{ userInfo.name }}
            </div>
            <div class="edit">Edit my profile</div>
          </div>
        </div>
      </div>

      <div class="line"></div>

      <el-upload
        :multiple="false"
        :auto-upload="true"
        :show-file-list="false"
        :action="upload.url"
        :on-success="handleUploadSuccess"
        :before-upload="beforeUpload"
        :headers="{ token: upload.token }"
      >
        <el-button>Upload</el-button>
      </el-upload>

      <div class="tasks-con">
        <div style="text-decoration: underline">Tasks</div>
        <div class="item">
          <div>GPS</div>
          <el-switch
            v-model="gpsSetting"
            active-value="on"
            inactive-value="off"
            active-color="#13ce66"
            inactive-color="#ff4949"
            @change="gpsSettingChange"
          >
          </el-switch>
        </div>
        <div class="item">
          <div>Heart Rate</div>
          <el-switch
            active-value="on"
            inactive-value="off"
            active-color="#13ce66"
            inactive-color="#ff4949"
          >
          </el-switch>
        </div>
        <div class="item">
          <div>Temperature</div>
          <el-switch
            active-value="on"
            inactive-value="off"
            active-color="#13ce66"
            inactive-color="#ff4949"
          >
          </el-switch>
        </div>
      </div>

      <div class="menu-con">
        <div
          class="bt"
          :class="{ active: curPage == 'personal' }"
          @click="curPage = 'personal'"
        >
          Personal
        </div>
        <div
          class="bt"
          :class="{ active: curPage == 'dynamic' }"
          @click="curPage = 'dynamic'"
        >
          Dynamic
        </div>
        <div class="bt">Media</div>
        <div class="bt">Reports</div>
      </div>

      <div v-if="curPage == 'personal'">
        <div class="table-con">
          <table>
            <tr>
              <th>Information</th>
              <th>Data</th>
            </tr>

            <div style="height: 1px"></div>

            <tr>
              <td>Name</td>
              <td>{{ userInfo.name }}</td>
            </tr>
            <tr>
              <td>Surname</td>
              <td>{{ userInfo.surname }}</td>
            </tr>
            <tr>
              <td>Age</td>
              <td>{{ userInfo.age }}</td>
            </tr>
            <tr>
              <td>Gender</td>
              <td>{{ userInfo.gender }}</td>
            </tr>
            <tr>
              <td>Date of Birth</td>
              <td>{{ userInfo.date_of_birth }}</td>
            </tr>
            <tr>
              <td>Fiscal Code</td>
              <td>{{ userInfo.fiscal_code }}</td>
            </tr>
            <tr>
              <td>Address</td>
              <td>{{ userInfo.address }}</td>
            </tr>
            <tr>
              <td>Phone</td>
              <td>{{ userInfo.phone }}</td>
            </tr>
            <tr>
              <td>Email</td>
              <td>{{ userInfo.email }}</td>
            </tr>
            <tr>
              <td>User ID</td>
              <td>{{ userInfo.id }}</td>
            </tr>
          </table>
        </div>

        <div class="table-con">
          <table>
            <tr>
              <th>Disease</th>
              <th>Response</th>
            </tr>

            <div style="height: 1px"></div>

            <tr>
              <td>Visual disability</td>
              <td>{{ userInfo.medical_history.visual_disability }}%</td>
            </tr>
            <tr>
              <td>Mobility disability</td>
              <td>{{ userInfo.medical_history.mobility_disability }}%</td>
            </tr>
            <tr>
              <td>Wheelchair user</td>
              <td>
                {{
                  userInfo.medical_history.wheelchair_user == 1 ? "Yes" : "No"
                }}
              </td>
            </tr>
            <tr>
              <td>Hypertension</td>
              <td>
                {{ userInfo.medical_history.hypertension == 1 ? "Yes" : "No" }}
              </td>
            </tr>
            <tr>
              <td>Diabetes</td>
              <td>
                {{ userInfo.medical_history.diabetes == 1 ? "Yes" : "No" }}
              </td>
            </tr>
            <tr>
              <td>Asthma</td>
              <td>
                {{ userInfo.medical_history.asthma == 1 ? "Yes" : "No" }}
              </td>
            </tr>
            <tr>
              <td>Arthritis</td>
              <td>
                {{ userInfo.medical_history.arthritis == 1 ? "Yes" : "No" }}
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div v-if="curPage == 'dynamic'" class="dynamic-con">
        <div class="date-con">
          <el-date-picker
            v-model="sessionDate"
            style="width: calc(100vw - 30px)"
            type="date"
            placeholder="Date"
            :clearable="false"
            align="right"
            size="medium"
            value-format="timestamp"
            @change="sessionDateChanged"
          >
          </el-date-picker>

          <el-button
            size="medium"
            style="margin-top: 20px"
            @click="clickViewAllSessions"
            >View All Sessions</el-button
          >
        </div>

        <div v-if="curViewSessionDataIndex == -1" class="data-table">
          <table>
            <thead>
              <tr>
                <th>Time</th>
                <th>Sensors</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in sessionData" :key="index">
                <td>{{ item.upload_date }} {{ item.time }}</td>
                <td>EDA、BVP、Acc、HR、Temp、GPS</td>
                <td>
                  <el-button size="mini" @click="clickView(index)"
                    >View</el-button
                  >
                  <el-button size="mini" @click="clickDownload(index)"
                    >Download</el-button
                  >
                  <el-button size="mini" @click="clickDelete(index)"
                    >Delete</el-button
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div id="chartContainer" v-else class="chart-con">
          <el-button size="medium" @click="curViewSessionDataIndex = -1"
            >Return</el-button
          >
          <div class="border">
            <EDAChart
              :path="path"
              :min-date-time="date_time.min"
              :max-date-time="date_time.max"
            ></EDAChart>
          </div>
          <div class="border">
            <BVPChart
              :path="path"
              :min-date-time="date_time.min"
              :max-date-time="date_time.max"
            ></BVPChart>
          </div>
          <div class="border">
            <ACCChart
              :path="path"
              :min-date-time="date_time.min"
              :max-date-time="date_time.max"
            ></ACCChart>
          </div>
          <div class="border">
            <HRChart
              :path="path"
              :min-date-time="date_time.min"
              :max-date-time="date_time.max"
            ></HRChart>
          </div>
          <div class="border">
            <TEMPChart
              :path="path"
              :min-date-time="date_time.min"
              :max-date-time="date_time.max"
            ></TEMPChart>
          </div>

          <div class="border">
            <table>
              <tr>
                <th>GPS</th>
                <th>latitude</th>
                <th>longitude</th>
                <th>Time</th>
              </tr>
              <tr v-for="(item, index) in gpsData" :key="index">
                <td></td>
                <td>{{ item.latitude }}</td>
                <td>{{ item.longitude }}</td>
                <td>{{ item.create_time }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import EDAChart from "./components/EDAChart";
import BVPChart from "./components/BVPChart";
import ACCChart from "./components/ACCChart";
import HRChart from "./components/HRChart";
import TEMPChart from "./components/TEMPChart";
import { getToken } from "@/utils/auth";
import { getGPS, setGPS } from "@/utils/gps";
import { getData, del as delData, getGPSData, addGPSData } from "@/api/data";
export default {
  components: {
    EDAChart,
    BVPChart,
    ACCChart,
    HRChart,
    TEMPChart,
  },
  data() {
    return {
      curPage: "personal",
      sessionDate: "",
      curViewSessionDataIndex: -1,

      upload: {
        url: "",
        token: "",
      },

      gpsSetting: "off",
      gpsTimeout: null,

      sessionData: [],
      path: "",
      date_time: {
        min: "",
        max: "",
      },
      gpsData: []
    };
  },
  computed: {
    ...mapState({
      userInfo: (state) => state.user.userInfo,
    }),
  },
  created() {
    this.upload.url = "/api/file/upload";
    this.upload.token = getToken();

    this.gpsSetting = getGPS() || "off";

    if (this.gpsSetting == "on") {
      this.startGPSTimer();
    }
  },
  mounted() {},
  methods: {
    handleUploadSuccess(res, file) {
      if (res.code != 0) {
        this.$message.error(res.msg);
        return false;
      }

      this.$message({
        message: "Upload successful",
        type: "success",
      });
    },
    beforeUpload(file) {
      const isJson = file.type === "application/json";
      const isLt10M = file.size / 1024 / 1024 < 10;
      if (!isJson) {
        this.$message.error("Uploading files can only be in JSON format");
      }
      if (!isLt10M) {
        this.$message.error("The upload file size cannot exceed 10MB");
      }
      return isJson && isLt10M;
    },
    clickViewAllSessions() {
      this.sessionDate = "";

      this.getData();
    },
    sessionDateChanged() {
      this.getData();
    },
    getData() {
      this.sessionData = [];
      this.curViewSessionDataIndex = -1;

      let uploadDate = this.sessionDate;
      if (uploadDate) {
        uploadDate = Math.round(uploadDate / 1000);
      }

      getData(uploadDate).then((response) => {
        this.sessionData = response.data;
      });
    },
    clickView(index) {
      this.curViewSessionDataIndex = index;
      this.path = this.sessionData[index].path;
      this.date_time.max = this.sessionData[index].max_date_time;
      this.date_time.min = this.sessionData[index].min_date_time;

      this.fetchGPSData();
    },
    fetchGPSData() {
      this.gpsData = [];
      getGPSData(this.sessionData[this.curViewSessionDataIndex].id).then((response) => {
        this.gpsData = response.data;
      });
    },
    async clickDownload(index) {
      const sessionData = this.sessionData[index];
      const path = this.sessionData[index].path;
      const date_time = `${sessionData.upload_date} ${sessionData.time}`;

      let jsonContent;

      try {
        const eda = (await axios.get(path + "/EDA.json")).data;
        const bvp = (await axios.get(path + "/BVP.json")).data;
        const acc = (await axios.get(path + "/ACC.json")).data;
        const hr = (await axios.get(path + "/HR.json")).data;
        const temp = (await axios.get(path + "/TEMP.json")).data;

        jsonContent = JSON.stringify(
          {
            date_time: date_time,
            eda: eda,
            bvp: bvp,
            acc: acc,
            hr: hr,
            temp: temp,
          },
          null,
          2
        );
      } catch (e) {
        this.$message.error("Error");
        return;
      }

      const blob = new Blob([jsonContent], { type: "application/json" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = date_time;
      a.click();
      URL.revokeObjectURL(url);
    },
    clickDelete(index) {
      if (confirm("Are you sure you want to delete it?")) {
        delData(this.sessionData[index].id).then((response) => {
          if (response.code == 0) {
            this.sessionData.splice(index, 1);
            this.$message({
              message: "Delete successful",
              type: "success",
            });
          }
        });
      }
    },
    clickLogout() {
      this.$store.dispatch("user/logout");
      this.$router.push("/login");
    },
    startGPSTimer() {
      clearTimeout(this.gpsTimeout);

      if (this.gpsSetting == "off") return;

      navigator.geolocation.getCurrentPosition(
        async (res) => {
          console.log({
            latitude: res.coords.latitude,
            longitude: res.coords.longitude,
          });

          try {
            await addGPSData({
              latitude: res.coords.latitude,
              longitude: res.coords.longitude,
            });
          } catch (e) {}

          clearTimeout(this.gpsTimeout);
          this.gpsTimeout = setTimeout(() => {
            this.startGPSTimer();
          }, 1000 * 5);
        },
        (err) => {
          this.$message.error("GPS ERROR");
          console.log(err);
        }
      );
    },
    gpsSettingChange() {
      setGPS(this.gpsSetting);
      if (this.gpsSetting == "on") {
        this.startGPSTimer();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.header {
  width: 100vw;
  height: 50px;
  background-color: rgb(21, 96, 130);
  border: 2px solid black;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 1000;

  .title {
    color: white;
    font-size: 20px;
    font-weight: bold;
    margin-left: 20px;
  }

  .logout {
    margin-right: 20px;
    color: #0c82d6;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
  }
}

.container {
  width: 100%;
  height: calc(100vh - 50px);
  overflow-y: scroll;
  padding-left: 15px;
  padding-right: 15px;
  padding-bottom: 15px;

  .user-con {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;

    .user {
      width: 100%;
      height: 75px;
      display: flex;
      padding-top: 5px;

      .avatar {
        width: 60px;
        height: 60px;
      }

      .right {
        width: 100%;
        height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-left: 20px;

        .name {
          font-size: 25px;
          font-weight: 900;
          color: #0071c1;
        }

        .edit {
          font-size: 15px;
          font-weight: bold;
          color: #0071c1;
          text-decoration: underline;
          cursor: pointer;
        }
      }
    }
  }

  .line {
    height: 1px;
    border-top: 1px solid black;
  }

  /deep/.el-upload {
    width: 100%;
    margin-top: 15px;

    button {
      width: 100%;
    }
  }

  .tasks-con {
    width: 100%;
    margin-top: 15px;

    .item {
      display: flex;
      align-items: center;
      margin-top: 10px;

      div:first-child {
        width: 130px;
      }
    }

    div {
      font-size: 19px;
      color: black;
    }

    /deep/ .el-switch__core::before {
      content: "OFF";
      position: absolute;
      top: 0;
      right: 5px;
      color: #fff;
      font-size: 10px;
    }
    .is-checked /deep/ .el-switch__core::before {
      content: "ON";
      position: absolute;
      top: 0;
      left: 5px;
      color: #fff;
      font-size: 10px;
    }
  }

  .menu-con {
    width: 100%;
    height: 50px;
    background-color: #00b0f0;
    border: 1px solid black;
    display: flex;
    align-items: center;
    justify-content: space-around;
    font-weight: bold;
    color: black;
    margin-top: 15px;

    .bt {
      display: flex;
      align-items: center;
      justify-content: center;
      width: calc(100% / 4.5);
      height: 36px;
      background-color: #93d051;
      border: 2px solid black;
      border-radius: 5px;
      cursor: pointer;

      &.active {
        color: #0071c1;
      }
    }
  }

  .table-con {
    margin-top: 30px;

    table {
      border-collapse: separate;
      border-spacing: 1px;
    }

    tr {
      background-color: #f2f2f2;
    }

    th {
      background-color: #146082;
      color: white;
      text-align: center;
      font-weight: bold;
    }

    tr td {
      width: 300px;
      color: black;
      padding-left: 10px;
    }

    tr td:first-child {
      background-color: #146082;
      color: white;
      font-weight: bold;
      width: 200px;
    }
  }

  .dynamic-con {
    margin-top: 30px;

    .date-con {
    }

    .data-table {
      table {
        border-collapse: collapse;
        width: 100%;
        border: 2px solid black;
        table-layout: fixed;
        word-break: break-all;
        margin-top: 30px;
      }

      th,
      td {
        text-align: center;
        padding: 8px;
        font-size: 20px;
      }

      th {
        background-color: #0071c1;
        color: black;
      }

      table tbody {
        display: block;
        max-height: 50vh;
        overflow-y: scroll;

        .el-button {
          width: 100%;
        }

        .el-button + .el-button {
          margin-left: 0px;
          margin-top: 5px;
        }
      }

      table thead,
      tbody tr {
        width: 100%;
        display: table;
        table-layout: fixed;
      }
    }

    .chart-con {
      margin-top: 30px;

      .border {
        width: 100%;
        border: 1px solid black;
        margin-top: 30px;
      }

      table {
        width: 100%;
        border: none;
        border-collapse: collapse;
      }

      th,
      td {
        text-align: center;
        padding: 5px;
        font-size: 18px;
      }

      th {
        background-color: yellowgreen;
        font-weight: 500;
      }
    }
  }
}
</style>
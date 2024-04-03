<template>
  <div>
    <div class="header">
      <div class="title">User | Welcome to CDT</div>
      <div class="logout" @click="clickLogout">Logout</div>
    </div>

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
        <el-upload
          :multiple="false"
          :auto-upload="true"
          :show-file-list="false"
          :action="upload.url"
          :on-success="handleUploadSuccess"
          :before-upload="beforeUpload"
          :headers="{ token: upload.token }"
        >
          <el-button style="margin-top: 10px; width: 230px"
            >Upload All Data</el-button
          >
        </el-upload>
        <el-button
          style="margin-top: 10px; width: 230px"
          @click="clickDownloadAllData"
          >Download All Data</el-button
        >

        <div class="user-list">
          <div>Users</div>
          <div
            class="item"
            v-for="(item, index) in userList"
            :key="index"
            @click="clickSelectUser(index)"
          >
            ID: {{ item.id }}
          </div>
        </div>
      </div>

      <div class="line"></div>

      <div v-if="curSelectUserIndex != -1" class="right-con">
        <div class="menu-con">
          <div>
            USER ID: {{ userList[curSelectUserIndex].id }} |
            {{ userList[curSelectUserIndex].surname }}
            {{ userList[curSelectUserIndex].name }}
          </div>
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

        <div v-if="curPage == 'personal'" class="table-con">
          <div>
            <table>
              <tr>
                <th>Information</th>
                <th>Data</th>
              </tr>

              <div style="height: 1px"></div>

              <tr>
                <td>Name</td>
                <td>{{ userList[curSelectUserIndex].name }}</td>
              </tr>
              <tr>
                <td>Surname</td>
                <td>{{ userList[curSelectUserIndex].surname }}</td>
              </tr>
              <tr>
                <td>Age</td>
                <td>{{ userList[curSelectUserIndex].age }}</td>
              </tr>
              <tr>
                <td>Gender</td>
                <td>{{ userList[curSelectUserIndex].gender }}</td>
              </tr>
              <tr>
                <td>Date of Birth</td>
                <td>{{ userList[curSelectUserIndex].date_of_birth }}</td>
              </tr>
              <tr>
                <td>Fiscal Code</td>
                <td>{{ userList[curSelectUserIndex].fiscal_code }}</td>
              </tr>
              <tr>
                <td>Address</td>
                <td>{{ userList[curSelectUserIndex].address }}</td>
              </tr>
              <tr>
                <td>Phone</td>
                <td>{{ userList[curSelectUserIndex].phone }}</td>
              </tr>
              <tr>
                <td>Email</td>
                <td>{{ userList[curSelectUserIndex].email }}</td>
              </tr>
              <tr>
                <td>User ID</td>
                <td>{{ userList[curSelectUserIndex].id }}</td>
              </tr>
            </table>
          </div>

          <div style="margin-left: 50px">
            <table>
              <tr>
                <th>Disease</th>
                <th>Response</th>
              </tr>

              <div style="height: 1px"></div>

              <tr>
                <td>Visual disability</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history
                      .visual_disability
                  }}%
                </td>
              </tr>
              <tr>
                <td>Mobility disability</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history
                      .mobility_disability
                  }}%
                </td>
              </tr>
              <tr>
                <td>Wheelchair user</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history
                      .wheelchair_user == 1
                      ? "Yes"
                      : "No"
                  }}
                </td>
              </tr>
              <tr>
                <td>Hypertension</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history.hypertension ==
                    1
                      ? "Yes"
                      : "No"
                  }}
                </td>
              </tr>
              <tr>
                <td>Diabetes</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history.diabetes == 1
                      ? "Yes"
                      : "No"
                  }}
                </td>
              </tr>
              <tr>
                <td>Asthma</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history.asthma == 1
                      ? "Yes"
                      : "No"
                  }}
                </td>
              </tr>
              <tr>
                <td>Arthritis</td>
                <td>
                  {{
                    userList[curSelectUserIndex].medical_history.arthritis == 1
                      ? "Yes"
                      : "No"
                  }}
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div v-if="curPage == 'dynamic'" class="dynamic-con">
          <div class="date-con">
            <el-date-picker
              v-model="sessionDate"
              style="width: 350px"
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

          <table v-if="curViewSessionDataIndex == -1">
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

          <div
            id="chartContainer"
            v-else
            class="chart-con"
            :style="{ height: chartContainerHeight + 'px' }"
          >
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
import {
  getData,
  del as delData,
  getGPSData,
  download as downloadAll,
} from "@/api/data";
import { getList as getUserList } from "@/api/user";
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
      chartContainerHeight: 0,

      upload: {
        url: "",
        token: "",
      },

      userList: [],
      curSelectUserIndex: -1,

      sessionData: [],
      path: "",
      date_time: {
        min: "",
        max: "",
      },
      gpsData: [],
    };
  },
  computed: {
    ...mapState({
      userInfo: (state) => state.user.userInfo,
    }),
  },
  created() {
    this.resetData();
  },
  mounted() {},
  methods: {
    getUserList() {
      getUserList().then((response) => {
        this.userList = response.data;
      });
    },
    clickSelectUser(index) {
      this.curSelectUserIndex = index;
      this.curPage = "personal";
      this.sessionDate = [];
      this.curViewSessionDataIndex = -1;
      this.chartContainerHeight = 0;
      this.sessionData = [];
      this.path = "";
      this.date_time = {
        min: "",
        max: "",
      };
      this.gpsData = [];
    },
    resetData() {
      this.upload.url = "/admin/file/upload";
      this.upload.token = getToken();

      this.getUserList();
    },
    clickDownloadAllData() {
      const loading = this.$loading({
        lock: true,
        text: "Loading",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)",
      });

      downloadAll()
        .then((response) => {
          const jsonContent = JSON.stringify(response.data, null, 2);

          const blob = new Blob([jsonContent], { type: "application/json" });
          const url = URL.createObjectURL(blob);
          const a = document.createElement("a");
          a.href = url;
          a.download = 'all_user_data_' + new Date().getTime();
          a.click();
          URL.revokeObjectURL(url);

          loading.close();
        })
        .catch((err) => {
          loading.close();
        });
    },
    initChartContainerHeight() {
      const dom = document.getElementById("chartContainer");
      this.chartContainerHeight = document.body.clientHeight - dom.offsetTop;
    },
    handleUploadSuccess(res, file) {
      if (res.code != 0) {
        this.$message.error(res.msg);
        return false;
      }

      this.$message({
        message: "Upload successful",
        type: "success",
      });

      this.resetData();
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

      getData(this.userList[this.curSelectUserIndex].id, uploadDate).then(
        (response) => {
          this.sessionData = response.data;
        }
      );
    },

    clickView(index) {
      this.curViewSessionDataIndex = index;
      this.path = this.sessionData[index].path;
      this.date_time.max = this.sessionData[index].max_date_time;
      this.date_time.min = this.sessionData[index].min_date_time;

      this.$nextTick(() => {
        this.initChartContainerHeight();
      });
      this.fetchGPSData();
    },
    fetchGPSData() {
      this.gpsData = [];
      getGPSData(
        this.userList[this.curSelectUserIndex].id,
        this.sessionData[this.curViewSessionDataIndex].id
      ).then((response) => {
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
      this.$confirm("Are you sure you want to delete it?", "Prompt", {
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel",
        type: "warning",
      })
        .then(() => {
          delData(
            this.userList[this.curSelectUserIndex].id,
            this.sessionData[index].id
          ).then((response) => {
            if (response.code == 0) {
              this.sessionData.splice(index, 1);
              this.$message({
                message: "Delete successful",
                type: "success",
              });
            }
          });
        })
        .catch((err) => {});
    },
    clickLogout() {
      this.$store.dispatch("user/logout");
      this.$router.push("/login");
    },
  },
};
</script>

<style lang="scss" scoped>
.header {
  height: 50px;
  background-color: rgb(21, 96, 130);
  border: 2px solid black;
  display: flex;
  align-items: center;
  justify-content: space-between;

  .title {
    color: white;
    font-size: 25px;
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
  display: flex;
  height: calc(100vh - 50px);

  .user-con {
    width: 260px;
    display: flex;
    flex-direction: column;
    align-items: center;

    .user {
      width: 100%;
      height: 75px;
      display: flex;
      padding-top: 5px;
      padding-left: 15px;
      padding-right: 15px;

      .avatar {
        width: 70px;
        height: 70px;
      }

      .right {
        width: 160px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-left: 20px;

        .name {
          font-size: 30px;
          font-weight: 900;
          color: #0071c1;
        }

        .edit {
          font-size: 19px;
          font-weight: bold;
          color: #0071c1;
          text-decoration: underline;
          cursor: pointer;
        }
      }
    }

    .user-list {
      width: 260px;
      height: 60%;
      // display: flex;
      // flex-direction: column;
      // align-items: start;
      margin-top: 40px;
      padding: 15px;
      text-align: left;
      color: black;
      font-weight: bold;
      font-size: 19px;
      overflow-y: scroll;

      .item {
        margin-top: 15px;
        text-decoration: underline;
        cursor: pointer;
        background-color: rgb(199, 199, 199);
        padding: 5px;
        border-radius: 5px;
      }
    }
  }

  .line {
    width: 1px;
    height: calc(100% - 40px);
    border-left: 1px solid black;
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .right-con {
    width: 100%;
    margin: 20px;

    .menu-con {
      width: 100%;
      height: 50px;
      background-color: #00b0f0;
      border: 1px solid black;
      display: flex;
      align-items: center;
      font-size: 20px;
      font-weight: bold;
      color: black;
      padding-left: 20px;
      padding-right: 20px;

      .bt {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 15px;
        width: 100px;
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
      display: flex;
      margin-top: 30px;

      table {
        border-collapse: separate;
        border-spacing: 1px;
      }

      tr:nth-child(even) {
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
      display: flex;

      .date-con {
        display: flex;
        flex-direction: column;
      }

      table {
        border-collapse: collapse;
        width: 100%;
        margin-left: 20px;
        border: 2px solid black;
        table-layout: fixed;
        word-break: break-all;
      }

      th,
      td {
        text-align: left;
        padding: 8px;
        font-size: 20px;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
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
          margin-left: 3px;
        }
      }

      table thead,
      tbody tr {
        width: 100%;
        display: table;
        table-layout: fixed;
      }

      .chart-con {
        margin-left: 20px;
        // display: flex;
        // flex-direction: column;
        overflow-y: scroll;
        padding-bottom: 30px;

        .border {
          width: 800px;
          border: 1px solid black;
          margin-top: 30px;
        }

        table {
          width: 100%;
          margin-left: 0;
          border: none;
        }

        th,
        td {
          text-align: left;
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
}
</style>
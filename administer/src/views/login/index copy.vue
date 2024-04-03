<template>
  <div>
    <div class="header">
      <div class="title">Welcome to CDT</div>
    </div>

    <div class="logo">Citizen Digital Twin</div>

    <div class="container">
      <div class="login-con">
        <div class="title-con">
          <img class="icon" src="@/assets/images/user-login.jpg" />
          <div class="title">User Login</div>
        </div>
        <el-input
          style="margin-top: 7px"
          v-model="userLoginForm.email"
          size="medium"
          placeholder="Enter your email"
          maxlength="255"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="userLoginForm.password"
          size="medium"
          placeholder="Enter your password"
          show-password
          maxlength="20"
        ></el-input>
        <div class="bt-con">
          <el-button @click="clickUserLogin">Login</el-button>

          <div class="gr">Forgot Password?</div>
        </div>
        <div class="bt-con">
          <div class="ge">Don't have an account?</div>

          <div class="gr">Sign Up</div>
        </div>
        <div class="bt-con">
          <div class="ge">Need assistance?</div>

          <div class="gr">Get Online Help</div>
        </div>
      </div>
      <div class="login-con">
        <div class="title-con">
          <img class="icon" src="@/assets/images/admin-login.jpg" />
          <div class="title">Admin Login</div>
        </div>
        <el-input
          style="margin-top: 7px"
          v-model="adminLoginForm.email"
          size="medium"
          placeholder="Enter your email"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="adminLoginForm.password"
          size="medium"
          placeholder="Enter your password"
          show-password
        ></el-input>
        <div class="bt-con">
          <el-button>Login</el-button>

          <div class="gr">Forgot Password?</div>
        </div>
        <div class="bt-con">
          <div class="ge">Don't have an account?</div>

          <div class="gr">Sign Up</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { validEmail } from "@/utils/validate";
export default {
  data() {
    return {
      userLoginForm: {
        email: "123456789@qq.com",
        password: "123456",
      },
      adminLoginForm: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    clickUserLogin() {
      if (!validEmail(this.userLoginForm.email)) {
        this.$message.error("请输入正确的邮箱");
        return false;
      }
      if (!this.userLoginForm.password.length) {
        this.$message.error("请输入密码");
        return false;
      }
      this.$store
        .dispatch("user/login", this.userLoginForm)
        .then(() => {
          this.$router.push({ path: '/index'});
        })
        .catch(() => {});
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

  .title {
    color: white;
    font-size: 25px;
    font-weight: bold;
    margin-left: 20px;
  }
}

.logo {
  color: black;
  font-size: 50px;
  font-weight: bold;
  text-align: center;
  margin-top: 50px;
}

.container {
  display: flex;
  justify-content: space-around;
  margin-top: 50px;
  padding-left: 15%;
  padding-right: 15%;

  .login-con {
    width: auto;
    display: flex;
    flex-direction: column;

    .title-con {
      display: flex;
      align-items: center;
      margin-left: 10px;

      .icon {
        width: 50px;
        height: 50px;
      }

      .title {
        color: black;
        font-size: 30px;
        font-weight: bold;
        margin-left: 15px;
      }
    }

    .bt-con {
      display: flex;
      align-items: center;
      margin-top: 20px;

      .el-button {
        width: 105px;
        text-align: left;
        padding: 12px 18px;
      }

      .ge {
        font-size: 19px;
        font-weight: bold;
        color: black;
      }

      .gr {
        font-size: 19px;
        font-weight: bold;
        color: #4b7684;
        margin-left: 15px;
        text-decoration: underline;
        cursor: pointer;
      }
    }
  }
}
</style>
<template>
  <div>
    <div class="header">
      <div class="title">User login page</div>
    </div>

    <div class="title-con">
      <img class="icon" src="@/assets/images/user-login.jpg" />
      <div class="title">User register</div>
    </div>

    <div class="logo">Sign Up</div>

    <div class="container">
      <div class="sign-con">
        <el-input
          v-model="form.name"
          size="medium"
          placeholder="Name"
          maxlength="255"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="form.surname"
          size="medium"
          placeholder="Surname"
          maxlength="255"
        ></el-input>

        <el-select
          style="margin-top: 7px; width: 350px"
          v-model="form.gender"
          size="medium"
          placeholder="Select Gender"
        >
          <el-option key="Male" label="Male" value="Male"> </el-option>
          <el-option key="Woman" label="Woman" value="Woman"> </el-option>
        </el-select>

        <el-date-picker
          style="margin-top: 7px; width: 350px"
          v-model="form.date_of_birth"
          type="date"
          placeholder="Date of birth"
          :clearable="false"
          align="right"
          size="medium"
          value-format="yyyy-MM-dd"
        >
        </el-date-picker>

        <!-- <el-input-number
        style="margin-top: 7px"
        controls-position="right"
        v-model="form.age"
        :min="10"
        :max="50"
        label="Age"
      ></el-input-number> -->

        <el-input
          style="margin-top: 7px"
          v-model="form.fiscal_code"
          size="medium"
          placeholder="Fiscal Code"
          maxlength="255"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="form.address"
          size="medium"
          placeholder="Address"
          maxlength="255"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="form.phone"
          size="medium"
          placeholder="Phone"
          maxlength="255"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="form.email"
          size="medium"
          placeholder="Email"
          maxlength="50"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="form.password"
          size="medium"
          placeholder="Password"
          show-password
          maxlength="20"
        ></el-input>
        <el-input
          style="margin-top: 7px"
          v-model="form.confirm_password"
          size="medium"
          placeholder="Confirm password"
          show-password
          maxlength="20"
        ></el-input>

        <div class="bt-con">
          <el-button @click="clickConfirm">Sign up</el-button>
        </div>
        <div class="bt-con">
          <div class="ge">Already have an account?</div>

          <div class="gr" @click="clickSignIn">Sign In</div>
        </div>
      </div>
      <div class="opt-con">
        <el-button style="padding: 12px 60px 12px 18px"
        @click="showOptional = !showOptional">Click here for optional fields</el-button
        >

        <div v-show="showOptional" class="form-cel">
          <div class="title">Visual Disability</div>
          <el-input-number
            controls-position="right"
            v-model="form.medical_history.visual_disability"
            :min="0"
            :max="100"
            label="(0-100%)"
          ></el-input-number>
        </div>
        <div v-show="showOptional" class="form-cel">
          <div class="title">Mobility Disability</div>
          <el-input-number
            controls-position="right"
            v-model="form.medical_history.mobility_disability"
            :min="0"
            :max="100"
            label="(0-100%)"
          ></el-input-number>
        </div>
        <div v-show="showOptional" class="form-cel">
          <div class="title">Wheelchair User</div>
          <el-select
            v-model="form.medical_history.wheelchair_user"
            size="medium"
            placeholder="No"
          >
            <el-option key="Yes" label="Yes" value="1"> </el-option>
            <el-option key="No" label="No" value="0"> </el-option>
          </el-select>
        </div>
        <div v-show="showOptional" class="form-cel">
          <div class="title">Hypertension</div>
          <el-select
            v-model="form.medical_history.hypertension"
            size="medium"
            placeholder="No"
          >
            <el-option key="Yes" label="Yes" value="1"> </el-option>
            <el-option key="No" label="No" value="0"> </el-option>
          </el-select>
        </div>
        <div v-show="showOptional" class="form-cel">
          <div class="title">Diabetes</div>
          <el-select
            v-model="form.medical_history.diabetes"
            size="medium"
            placeholder="No"
          >
            <el-option key="Yes" label="Yes" value="1"> </el-option>
            <el-option key="No" label="No" value="0"> </el-option>
          </el-select>
        </div>
        <div v-show="showOptional" class="form-cel">
          <div class="title">Asthma</div>
          <el-select
            v-model="form.medical_history.asthma"
            size="medium"
            placeholder="No"
          >
            <el-option key="Yes" label="Yes" value="1"> </el-option>
            <el-option key="No" label="No" value="0"> </el-option>
          </el-select>
        </div>
        <div v-show="showOptional" class="form-cel">
          <div class="title">Arthritis</div>
          <el-select
            v-model="form.medical_history.arthritis"
            size="medium"
            placeholder="No"
          >
            <el-option key="Yes" label="Yes" value="1"> </el-option>
            <el-option key="No" label="No" value="0"> </el-option>
          </el-select>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { register } from "@/api/user";
import { validEmail } from "@/utils/validate";
export default {
  data() {
    return {
      form: {
        name: "",
        surname: "",
        gender: "",
        date_of_birth: "",
        fiscal_code: "",
        address: "",
        phone: "",
        email: "",
        password: "",
        confirm_password: "",

        medical_history: {
          visual_disability: "",
          mobility_disability: "",
          wheelchair_user: "0",
          hypertension: "0",
          diabetes: "0",
          asthma: "0",
          arthritis: "0",
        },
      },

      showOptional: false,
    };
  },
  methods: {
    clickSignIn() {
      this.$router.push({ path: "/login" });
    },
    clickConfirm() {
      if (!this.form.name.length) {
        this.$message.error("Please enter Name");
        return false;
      }
      if (!this.form.surname.length) {
        this.$message.error("Please enter Surname");
        return false;
      }
      if (!this.form.gender.length) {
        this.$message.error("Please select Gender");
        return false;
      }
      if (!this.form.date_of_birth.length) {
        this.$message.error("Please select Date of birth");
        return false;
      }
      if (!this.form.gender.length) {
        this.$message.error("Please select Gender");
        return false;
      }
      if (!this.form.fiscal_code.length) {
        this.$message.error("Please enter Fiscal code");
        return false;
      }
      if (!this.form.address.length) {
        this.$message.error("Please enter Address");
        return false;
      }
      if (!this.form.phone.length) {
        this.$message.error("Please enter phone");
        return false;
      }
      if (!validEmail(this.form.email)) {
        this.$message.error("Please enter the correct email");
        return false;
      }
      if (!this.form.password.length) {
        this.$message.error("Please enter Password");
        return false;
      }
      if (this.form.confirm_password != this.form.password) {
        this.$message.error("Two passwords do not match");
        return false;
      }

      register(this.form).then((response) => {
        this.$message({
          message: "Rgister successful",
          type: "success",
        });
        this.$router.push({ path: "/login" });
      });
    },
  }
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

.title-con {
  display: flex;
  align-items: center;
  margin-left: 20px;

  .icon {
    width: 75px;
    height: 75px;
  }

  .title {
    color: black;
    font-size: 50px;
    font-weight: bold;
    margin-left: 15px;
  }
}

.logo {
  margin-left: 40px;
  margin-top: -5px;
  color: black;
  font-size: 30px;
  font-weight: bold;
}

.container {
  margin-top: 7px;
  margin-left: 20px;
  display: flex;

  .sign-con {
    display: flex;
    flex-direction: column;
  }

  .opt-con {
    display: flex;
    flex-direction: column;
    margin-left: 16%;
  }

  .form-cel {
    display: flex;
    margin-top: 7px;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .title {
      font-weight: bold;
      font-size: 20px;
      color: black;
    }

    /deep/.el-input {
      width: 150px;
    }

    .el-input-number {
      width: 150px;
    }
  }

  .bt-con {
    display: flex;
    align-items: center;
    margin-top: 20px;

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
</style>
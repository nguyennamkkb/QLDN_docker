<template>
  <el-tabs v-model="activeName" @tab-click="handleClick">
    <el-tab-pane label="Chở hàng" name="first"><carrier></carrier></el-tab-pane>
    <el-tab-pane label="Thôi tăm" name="second">
      <cattam></cattam>
    </el-tab-pane>
    <el-tab-pane label="Đóng kiện" name="third">
      <dongkien></dongkien>
    </el-tab-pane>
    <el-tab-pane label="Task" name="fourth">
      <thoitam></thoitam>
    </el-tab-pane>
  </el-tabs>
</template>
<script>
import carrier from "./carrier.vue";
import cattam from "./cattam.vue";
import dongkien from "./dongkien.vue";
import thoitam from "./thoitam.vue";
export default {
  components: {
    carrier,
    cattam,
    dongkien,
    thoitam,
  },
  data() {
    return {
      activeName: "first",
    };
  },
  created() {},
  methods: {
    handleClick(tab, event) {
      console.log(tab, event);
    },
  },
};
</script>
<template>
  <div>
    <div>
      <el-form :label-position="'left'" label-width="100px">
        <el-row :gutter="20">
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <el-form-item label="Ngày">
                <el-date-picker
                  type="date"
                  placeholder="Chọn ngày"
                  style="width: auto"
                >
                </el-date-picker>
              </el-form-item>
              <el-form-item label="Người làm"> </el-form-item></div
          ></el-col>
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <el-form-item label="Người làm">
                <el-select filterable placeholder="Chọn">
                  <el-option
                    v-for="item in listCustomer"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="Activity zone">
                <el-input></el-input>
              </el-form-item></div
          ></el-col>
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <el-form-item label="Name">
                <el-input></el-input>
              </el-form-item>
              <el-form-item label="Activity zone">
                <el-input></el-input>
              </el-form-item></div
          ></el-col>
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <el-form-item label="Name">
                <el-input></el-input>
              </el-form-item>
              <el-form-item label="Activity zone">
                <el-input></el-input>
              </el-form-item></div
          ></el-col>
        </el-row>
      </el-form>
    </div>
  </div>
</template>

<script>
import {
  getCatDong,
  createCatDong,
  updateCatDong,
  deleteCatDong,
} from "../../../api/CatDong";
import { getEmployee } from "../../../api/Employee";
export default {
  data() {
    return {
      confirmPaymentDL: false,
      listQuery: {
        dateFrom: "2021-08",
        dateTo: Date(),
        customer_id: undefined,
        category_id: 1,
        category_idvau: 3,
        status: 1,
      },
      query1: {
        customerType_id: 2,
        limit: 200,
      },
      listCustomer: null,
      list: {
        customer: undefined,
        prepay: undefined,
        customer: undefined,
        data: null,
      },
    };
  },
  created() {},
  methods: {
    // getlistBook() {
    //   const data1 = null;
    //   getListPaymentBook(data1)
    //     .then((result) => {
    //       console.log(result.data);
    //     })
    //     .catch((err) => {});
    // },
    getList() {
      getCustomer(this.query1).then((response) => {
        this.listCustomer = response.data.data;
      });
    },
    getListThanhToanTam() {
      this.listQuery.dateFrom = convertToDate(this.listQuery.dateFrom);
      this.listQuery.dateTo = convertToDate(this.listQuery.dateTo);
      getListTam(this.listQuery).then((response) => {
        if (response.data.data.length) {
          this.list = response.data;
        }
      });
    },
    confirmPayment() {
      this.confirmPaymentDL = true;
    },
    handlePayment() {
      let datacreate = Object.assign({}, this.list);
      datacreate.inputid = [];
      datacreate.inputid1 = [];
      const a1 = datacreate.data;
      const a2 = datacreate.data1;
      a1.forEach((element) => {
        datacreate.inputid.push(element.id);
      });
      a2.forEach((element) => {
        datacreate.inputid1.push(element.id);
      });

      datacreate.data = JSON.stringify(datacreate.data);
      datacreate.data1 = JSON.stringify(datacreate.data1);
      console.log(datacreate);
      createBook(datacreate).then((result) => {
        // console.log(result.data);
      });
    }, // chốt sổ
  },
};
</script>
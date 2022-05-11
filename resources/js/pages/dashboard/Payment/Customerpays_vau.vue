<template>
  <div>
    <div>
      <el-row :gutter="20">
        <div style="text-align: center; margin: 10px">Thanh toán chủ Vầu</div>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>Chủ vầu</div>
            <div>
              <el-select
                v-model="listQuery.customer_id"
                filterable
                placeholder="Chọn"
              >
                <el-option
                  v-for="item in listCustomer"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </div>
          </div>
        </el-col>

        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>Đến ngày</div>
            <div>
              <el-date-picker
                v-model="listQuery.dateTo"
                type="date"
                placeholder="Pick a day"
              >
              </el-date-picker>
            </div></div
        ></el-col>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>-----</div>
            <div>
              <el-button type="primary" @click="getListThanhToanVau()"
                >Tìm kiếm</el-button
              >
            </div>
          </div>
        </el-col>
      </el-row>
    </div>
    <div v-if="list.data != null">
      <div style="padding-top: 20px">
        <div>Khách hàng: {{ this.list.customer }}</div>
        <div>Tổng tiền: {{ this.list.totalmoney }}</div>
        <div>Đã trả trước: {{ this.list.prepay }}</div>
      </div>
      <div>
        <el-table :data="this.list.data" border style="width: 100%">
          <el-table-column prop="date" label="Ngày" width="180">
          </el-table-column>
          <el-table-column prop="weight" label="Số KG" width="180">
          </el-table-column>
          <el-table-column prop="price" label="Giá"> </el-table-column>
          <el-table-column prop="total" label="Tổng tiền"> </el-table-column>
        </el-table>
      </div>
      <el-button type="primary" size="default" @click="confirmPayment()"
        >Chốt sổ</el-button
      >
    </div>
    <el-dialog
      title="Thông báo"
      :visible.sync="confirmPaymentDL"
      width="30%"
      center
    >
      <span>Số tiền trả hôm nay</span>
      <el-input placeholder="Nhập số tiền" v-model="list.paid"></el-input>

      <span slot="footer" class="dialog-footer">
        <el-button @click="confirmPaymentDL = false">Hủy</el-button>
        <el-button type="primary" @click="handlePayment()">Đồng ý</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { convertToDate } from "../../../handle/handleDate";
import { getCustomer } from "../../../api/Customer";
import { getListVau, createBook } from "../../../api/Payment";
import { getListPaymentBook } from "../../../api/PaymentBook";
export default {
  data() {
    return {
      confirmPaymentDL: false,
      listQuery: {
        dateFrom: "2019-1-1",
        dateTo: Date(),
        customer_id: undefined,
        category_id: 3,
        status: 1,
      },
      query1: {
        customerType_id: 1,
        limit: 200,
      },
      listCustomer: null,
      list: {
        customer: undefined,
        prepay: undefined,
        customer: undefined,
        data: null,
        data1: "",
      },
    };
  },
  created() {
    this.getListCustomer();
    // this.getlistBook();
  },
  methods: {
    // getlistBook() {
    //   const data1 = null;
    //   getListPaymentBook(data1)
    //     .then((result) => {
    //       console.log(result.data);
    //     })
    //     .catch((err) => {});
    // },
    getListCustomer() {
      getCustomer(this.query1).then((response) => {
        this.listCustomer = response.data.data;
      });
    },
    getListThanhToanVau() {
      // this.listQuery.dateFrom = convertToDate(this.listQuery.dateFrom);
      this.listQuery.dateTo = convertToDate(this.listQuery.dateTo);
      getListVau(this.listQuery).then((response) => {
        if (response.data) {
          this.list = response.data;
        }
      });
    },
    confirmPayment() {
      this.confirmPaymentDL = true;
    },
    handlePayment() {
      console.log("Ádasdasdsad");
      let datacreate = Object.assign({}, this.list);
      datacreate.inputid = [];
      const a1 = datacreate.data;
      a1.forEach((element) => {
        datacreate.inputid.push(element.id);
      });
      datacreate.data = JSON.stringify(datacreate.data);
      datacreate.data1 = JSON.stringify(datacreate.data1);
      createBook(datacreate).then((result) => {
        // console.log(result.data);
      });
    }, // chốt sổ
  },
};
</script>
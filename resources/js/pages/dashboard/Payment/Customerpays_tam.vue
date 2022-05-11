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
            <div>Từ ngày</div>
            <div>
              <el-date-picker
                v-model="listQuery.dateFrom"
                type="date"
                placeholder="Chọn ngày"
              >
              </el-date-picker>
            </div></div
        ></el-col>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>Đến ngày</div>
            <div>
              <el-date-picker
                v-model="listQuery.dateTo"
                type="date"
                placeholder="Chọn ngày"
              >
              </el-date-picker>
            </div></div
        ></el-col>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>-----</div>
            <div>
              <el-button type="primary" @click="getListThanhToanTam()"
                >Tìm kiếm</el-button
              >
            </div>
          </div>
        </el-col>
      </el-row>
    </div>
    <el-row v-if="list.data != null">
      <div style="padding-top: 20px">
        <div>Khách hàng: {{ this.list.customer }}</div>
        <div>Tổng tiền: {{ this.list.totalmoney }}</div>
        <div>Đã trả trước: {{ this.list.prepay }}</div>
      </div>
      <el-row>
        <el-col :span="12">
          <div style="text-align: center">Tăm</div>
          <div class="grid-content bg-purple">
            <el-table :data="this.list.data" border style="width: 100%">
              <el-table-column prop="date" label="Ngày" width="100">
              </el-table-column>
              <el-table-column prop="weight" label="Số KG" width="80">
              </el-table-column>
              <el-table-column prop="price" label="Giá" width="80">
              </el-table-column>
              <el-table-column prop="total" label="Tổng tiền">
              </el-table-column>
            </el-table></div
        ></el-col>
        <el-col :span="12">
          <div style="text-align: center">Vầu</div>
          <el-table :data="this.list.data1" border style="width: 100%">
            <el-table-column prop="date" label="Ngày" width="100">
            </el-table-column>
            <el-table-column prop="weight" label="Số KG" width="80">
            </el-table-column>
            <el-table-column prop="price" label="Giá" width="80">
            </el-table-column>
            <el-table-column prop="total" label="Tổng tiền"> </el-table-column>
          </el-table>
          <div class="grid-content bg-purple-light"></div
        ></el-col>
      </el-row>
    </el-row>

    <el-button type="primary" size="default" @click="confirmPayment()"
      >Chốt sổ</el-button
    >
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
import { getListTam, createBook } from "../../../api/Payment";
import { getListPaymentBook } from "../../../api/PaymentBook";
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
  created() {
    this.getListCustomer();
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
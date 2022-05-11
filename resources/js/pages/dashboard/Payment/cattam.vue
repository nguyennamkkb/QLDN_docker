<template>
  <div>Cat tam
    <div>
      
    </div>
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
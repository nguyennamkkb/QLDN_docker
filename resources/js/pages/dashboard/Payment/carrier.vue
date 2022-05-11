<template>
  <div>
    <div style="text-align: center">Thanh toán chở hàng</div>
    <div>
      <div>
        <el-row :gutter="20">
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <div>Người chở</div>
              <div>
                <el-select
                  v-model="listQuery.employee_id"
                  filterable
                  placeholder="Chọn"
                >
                  <el-option
                    v-for="item in listEmployee"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
              </div></div
          ></el-col>
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <div>Từ ngày</div>
              <div>
                <el-date-picker
                  v-model="listQuery.dateFrom"
                  type="date"
                  placeholder="Pick a day"
                >
                </el-date-picker>
              </div></div
          ></el-col>
          <el-col :span="6"
            ><div class="grid-content bg-purple">
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
          <el-col :span="6"
            ><div class="grid-content bg-purple">
              <div>----</div>
              <div>
                <el-button type="primary" size="default" @click="getList()"
                  >Tìm kiếm</el-button
                >
              </div>
            </div></el-col
          >
        </el-row>
      </div>
      <div v-if="list.employee != null">
        <div>
          Tên: {{ list.employee ? list.employee : "" }}, Tổng:
          {{ list.totalweigh ? list.totalweigh : "" }}
        </div>
        <div>
          <el-row :gutter="20">
            <el-col :span="12" :offset="0"
              ><el-table
                :data="list.data"
                border
                style="width: 100%; margin-top: 20px"
              >
                <el-table-column prop="date" label="Ngày"> </el-table-column>
                <el-table-column prop="weight" label="Số lượng(KG)">
                </el-table-column> </el-table
            ></el-col>
            <el-col :span="12" :offset="0"
              ><el-table
                :data="list.data1"
                border
                style="width: 100%; margin-top: 20px"
              >
                <el-table-column prop="date" label="Ngày"> </el-table-column>
                <el-table-column prop="weight" label="Số lượng(KG)">
                </el-table-column> </el-table
            ></el-col>
          </el-row>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { getEmployee } from "../../../api/Employee";
import { getListPaymentCarrier } from "../../../api/Payment";
import { convertToDate } from "../../../handle/handleDate";
export default {
  data() {
    return {
      listQuery1: {
        employeeType_id: 4,
      },
      listQuery: {
        employee_id: undefined,
        dateFrom: "",
        dateTo: "",
      },
      listEmployee: null,
      listData1: null,
      listData2: null,
      list: {
        employee: null,
        totalweight: null,
      },
    };
  },
  created() {
    this.getListEmployee();
  },
  methods: {
    getListEmployee() {
      getEmployee(this.listQuery1).then((response) => {
        this.listEmployee = response.data.data;

        setTimeout(() => {
          //   this.listLoading = false
        }, 0.5 * 1000);
      });
    },
    getList() {
      this.listQuery.dateFrom = convertToDate(this.listQuery.dateFrom);
      this.listQuery.dateTo = convertToDate(this.listQuery.dateTo);
      getListPaymentCarrier(this.listQuery).then((result) => {
        // console.log(result.data);
        this.list = result.data;
      });
    },
  },
};
</script>
<template>
  <div class="container pt-4"  >
    <h3 class="text-center">
    สมัครเป็น influencer
    </h3>
    <hr>
    {{form}}
    <div class="card p-4 mt-5" :class="form.gender">
      <div class="card-no" :class="{active: form.gender}">1</div>
      <div class="card-title gender" >
              เพศ
              <br>
              <button class="btn M" @click="setGender('M')" :class="{active: form.gender=='M'}">ชาย</button>
              <button class="btn F" @click="setGender('F')"   :class="{active: form.gender=='F'}">หญิง</button>
              <button class="btn L" @click="setGender('L')"   :class="{active: form.gender=='L'}">
                LGBT</button>
      </div>
    </div>


       <div class="card p-4 mt-5">
      <div class="card-no" :class="{active: form.age}">2</div>
      <div class="card-title">
              อายุ
              <br>
              <select class="form-control" v-model="form.age">
                                                <option value=""> -- กรุณาเลือก 1 รายการ --</option>

                                                <option value="1">ต่ำกว่า 18 ปี</option>

                <option value="2">18-23 ปี</option>

              </select>
      </div>
    </div>



       <div class="card p-4 mt-5">
      <div class="card-no" :class="{active: form.type.length}">3</div>
      <div class="card-title">
              ความถนัดของคุณ
              <br>


             <b-form-group >
      <b-form-checkbox-group
        v-model="form.type"
        :options="options"
        name="flavour-2a"
        stacked
      ></b-form-checkbox-group>
    </b-form-group>





      </div>
    </div>


        <div class="card p-4 mt-5">
      <div class="card-no" :class="{active: form.dislike}">4</div>
      <div class="card-title">
              สิ่งที่<span class="text-danger">ไม่</span>ถนัด
              <br>
              <textarea v-model="form.dislike" class="form-control"></textarea>
      </div>
    </div>



        <div class="card p-4 mt-5">
      <div class="card-no" :class="{active: form.follow}">5</div>
      <div class="card-title">
              ยอด Follower
              <br>
      <b-form-group >
      <b-form-radio-group
        v-model="form.follow"
        :options="optionsFollow"
        plain
        stacked
        name="plain-stacked"
      ></b-form-radio-group>
    </b-form-group>
      </div>
    </div>

       <div class="card p-4 mt-5">
      <div class="card-no">6</div>
      <div class="card-title">
              ประวัติการรีวิว
              <br>
        <input type="file" multiple class="form-control">
      </div>
    </div>

     <div class="card p-4 mt-5">
      <div class="card-no">7</div>
      <div class="card-title">
              งบประมาณที่ต้องการได้รับ/ 1รีวืว
              <br>
        <div class="input-group">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" aria-label="Radio button for following text input">
    </div>
  </div>
  <input type="text" class="form-control" aria-label="Text input with radio button">
</div>
      </div>
    </div>


     <div class="card p-4 mt-5">
      <div class="card-no">8</div>
      <div class="card-title">
             รูปภาพที่น่าสนใจของคุณ
              <br>
             <input type="file" class="form-control">

      </div>
    </div>


    <div class="card p-4 mt-5">
      <div class="card-no">9</div>
      <div class="card-title">
             ชื่อจริง
              <br>
             <input type="text" class="form-control">

      </div>
    </div>

        <div class="card p-4 mt-5">
      <div class="card-no">10</div>
      <div class="card-title">
             ชื่อเล่น
              <br>
             <input type="text" class="form-control">

      </div>
    </div>
  </div>
</template>

<script>
import {findIndex} from 'lodash'
export default {
data:()=>({
  selected:'A',
      cName:'',
       options: [
          { text: 'เสื้อผ้าและกีฬา', value: 1 },
          { text: 'เครื่องสำอางค์', value: 2 },
          { text: 'อาหาร', value: 3 },
          { text: 'ท่องเที่ยว', value: 4 },
                    { text: 'เทคโนโลยี แก็ดเจ็ด เกม', value: 5 }

        ],
         optionsFollow: [
          { text: 'ต่ำกว่า 1000', value: 1 },
          { text: '1,000 - 10,000', value: 2 },
          { text: '10,001 - 50,000', value: 3 },
          { text: '50,01 - 100,000', value: 4 },
          { text: '100,001 - 1,000,000', value: 5 },
          { text: '1,000,000 ขึ้นไป', value: 6 },

        ],
    form:{
      gender:'',
      age:'',
      type:[],
      dislike:'',
      follow:''

    }

}),
methods:{
  setGender(g){
    this.form.gender = g
  },
  setType(n){
    let find = findIndex(this.form.type, el => el == n)
          this.form.type.splice(find,1)

    this.form.type.push(n)
  }
}
}
</script>

<style scoped>
button {
  border:none;
    margin-top: 10px;

  margin-bottom: 10px;
  margin-right: 10px;
  border-radius: 10px;
}
.gender .active{
  background: #fff;
  color: #147aab;
  transition: 0.5 all;
}
.card-no{
  width: 45px;
    height: -13px;
    border: 1px solid #ccc;
    background-color: #eee;
    text-align: center;
    padding: 10px;
    border-radius: 50%;
    position: absolute;
    margin-left: -15px;
    margin-top: -50px;
    color: #333;
}
.card-no.active{
  background:royalblue;
      border: 1px solid royalblue;

  color: #fff;
}
.M{
    color: #fff;

  background-color: #147aab;
}
.F{
    color: #fff;

  background-color: pink;
}
.L {
  color: #fff;
  --g-red: #d04b36;
  --g-orange: #e36511;
  --g-yellow: #ffba00;
  --g-green: #00b180;
  --g-blue: #147aab;
  --g-indigo: #675997;
  background-image: linear-gradient(
    var(--g-red) 0%,
    var(--g-red) 16.6666%,
    var(--g-orange) 16.6666%,
    var(--g-orange) 33.333%,
    var(--g-yellow) 33.333%,
    var(--g-yellow) 50%,
    var(--g-green) 50%,
    var(--g-green) 66.6666%,
    var(--g-blue) 66.6666%,
    var(--g-blue) 83.3333%,
    var(--g-indigo) 83.3333%,
    var(--g-indigo) 100%
  );
}

</style>

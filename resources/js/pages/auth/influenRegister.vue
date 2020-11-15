<template>
  <div class="container pt-4">
    <h3 class="text-center">
    สมัครเป็น influencer
    </h3>
    <div class="card p-4">
      <div class="card-no">1</div>
      <div class="card-title">
              เพศ
              <br>
              <button class="male">ชาย</button>
              <button class="female">หญิง</button>
              <button class="lgbt">
                LGBT</button>
      </div>
    </div>


       <div class="card p-4 mt-5">
      <div class="card-no">2</div>
      <div class="card-title">
              อายุ
              <br>
              <select class="form-control">
                <option value="">18-23 ปี</option>
              </select>
      </div>
    </div>



       <div class="card p-4 mt-5">
      <div class="card-no">3</div>
      <div class="card-title">
              ความถนัดของคุณ
              <br>
              <button>เสื้อผ้าและกีฬา</button>
              <button>เครื่องสำอางค์</button>
              <button>อาหาร</button>
              <br>
              <button>ท่องเที่ยว</button>
              <button>เทคโนโลยี แก็ดเจ็ด เกม</button>
      </div>
    </div>


        <div class="card p-4 mt-5">
      <div class="card-no">4</div>
      <div class="card-title">
              สิ่งที่<span class="text-danger">ไม่</span>ถนัด
              <br>
              <input type="radio" name="" id="">
              <textarea name="" id="" cols="30" rows="10"></textarea>
      </div>
    </div>



        <div class="card p-4 mt-5">
      <div class="card-no">5</div>
      <div class="card-title">
              ยอด Follower
              <br>
       <b-form-group label="Individual radios">
      <b-form-radio v-model="selected" name="some-radios" value="A">Option A</b-form-radio>
      <b-form-radio v-model="selected" name="some-radios" value="B">Option B</b-form-radio>
            <b-form-radio v-model="selected" name="some-radios" value="B">Option B</b-form-radio>

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
export default {
data:()=>({
  selected:'A'
})
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
}
.male{
    color: #fff;

  background-color: #147aab;
}
.female{
    color: #fff;

  background-color: pink;
}
.lgbt {
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

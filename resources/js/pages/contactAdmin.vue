<template>
  <div class="container">
    <div class="row">
      <b-container fluid>
        <br />
        <h3 class="text-center">แจ้งปัญหา</h3>
        <b-row class="my-1">
          <b-col sm="10">
            <label for="input-default">1: ชื่อผู้แจ้ง</label>
            <b-form-input
              id="input-default"
              placeholder="Enter your name"
            ></b-form-input>
          </b-col>
        </b-row>

        <b-row class="mt-2">
          <b-col sm="10">
            <label for="textarea-default">2:ปัญหาที่เกิดขึ้น</label>
            <b-form-textarea
              id="textarea-default"
              placeholder=""
            ></b-form-textarea>
          </b-col>
        </b-row>

        <b-row class="my-1">
          <b-col sm="10">
            <label for="input-default">3:ชื่ออินฟลูเชอร์</label>
            <b-form-input
              id="input-default"
              placeholder="Enter name"
            ></b-form-input>
          </b-col>
        </b-row>

        <b-row class="my-1">
          <b-col sm="10">
            <label for="input-default">4:หลักฐานรูปภาพ</label>
            <b-form-file id="file-default"></b-form-file>
            <b-form-file id="file-default"></b-form-file>
            <b-form-file id="file-default"></b-form-file>
            <b-form-file id="file-default"></b-form-file>
            <b-form-file id="file-default"></b-form-file>
            <b-form-file id="file-default"></b-form-file>
          </b-col>
        </b-row>
        <b-button variant="secondary">ย้อนกลับ</b-button>
        <b-button variant="success">ส่งหลักฐาน</b-button>
      </b-container>
    </div>
  </div>
</template>

<script>
</script>

<style>
</style>

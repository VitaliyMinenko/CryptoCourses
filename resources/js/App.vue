<template>
  <div class="container main">
    <Header />
    <MainTable />
  </div>
</template>

<script>
import MainTable from "./components/MainTable";
import Header from "./components/Header";

export default {
  name:'app',
  components: {MainTable, Header},
  comments: {
    MainTable,
    Header
  }
}
</script>

<style scoped>
.main{
  background-color: #F3F5F7;
}
</style>
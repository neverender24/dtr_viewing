<template>
	<div class="col-md-8 col-md-offset-2">

  <div class="table-responsive">
		<table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Day</th>
              <th>AM IN</th>
              <th>AM OUT</th>
              <th>PM IN</th>
              <th>PM OUT</th>
              <th>UNDER</th>
              <th>REMARKS</th>
            </tr>
          </thead>
          <tbody >
            <tr v-for="item,key in dtr">
              <td>{{ item.fdate.substr(item.fdate.length - 2)}}</td>
              <td>{{ item.famin }}</td>
              <td>{{ item.famout }}</td>
              <td>{{ item.fpmin }}</td>
              <td>{{ item.fpmout }}</td>
              <td>{{ item.funder==0?"":item.funder }}</td>
              <td>{{ item.fremks }}</td>
            </tr>
          </tbody>
      </table>
    </div>
	</div>	
</template>
<script>
	export default{
    props: {
      dtr: {}
    }
	}
</script>
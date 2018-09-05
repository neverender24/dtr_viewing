<template>
		<div>
			<div class="loading" v-if="loading">Loading&#8230;</div>
			<div class="col-md-8 col-md-offset-2">
				<div class="form-group col-md-2">
					<el-input placeholder="Month" max="2" v-model="months" @change="setMonth" autofocus="true"></el-input>
				</div>
				<div class="form-group col-md-2">
					<el-input placeholder="Year" max="4" v-model="years" @change="setYear"></el-input>
				</div>
				<div class="form-group col-md-2">
					<el-input placeholder="Id" max="4" v-model="ids" @change="setIds"></el-input>
				</div>
				<div class="form-group col-md-2">
					<el-select v-model="limit" placeholder="Period" @change="setPeriod">
						<el-option
							v-for="item in options"
							:key="item.value"
							:label="item.label"
							:value="item.value">
						</el-option>
					</el-select>
				</div>
				
				<div class="form-group col-md-2">
						<el-button type="primary" @click="setPeriod()">Display</el-button>
						<el-button type="success" @click="printer()">Print</el-button>
				</div>
				<div class="form-group col-md-12" v-if="name">
					<span v-if="loading"><i class="text-primary fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i></span>
					<label for="first_name" class="column is-2">Name :</label> {{ name.FLAST }}, {{ name.FFIRST }} {{ name.FMI }}
				</div>
			</div>
			<div class="row">
				<view-dtr v-bind:dtr="lists"></view-dtr>
			</div>
		</div>
</template>
<script>
	import ViewDtr from "./Viewdtr.vue"

	export default{
		components: {
			ViewDtr
		},
	  data(){
	    return{
	      lists:{},
	      loading: false, //variable for loading when deleting
	      temp: '',
	      years : '',
	      months : '',
	      ids : '',
				name:null,
				options: [{
          value: '0, 15',
          label: 'First'
        }, {
          value: '16, 31',
          label: 'Second'
        }, {
          value: '0, 31',
          label: 'Month'
        }],
        limit: ''
	    }
	  },
	  mounted(){
	  		this.getResults(this.years, this.months, this.ids, this.limit);
	  },
	  methods:{

	        getResults(year, month, id, limit) {
	          this.loading = !this.loading
	            axios.post('getDtr',{
								 searchYear: year,
								 searchMonth: month,
								 searchId: id,
								 limit: limit,
							})
	            .then(response => {
	              this.loading = !this.loading;
	              this.lists = response.data;

	              this.temp = this.lists.filter((item) => {

	              	let string = String(item["fdate"])
	              		
	              		return string.substring(8,10)
	              })
	            })
	        },
	        getEmployees(id){
	        	axios.post('getEmployee', { searchId: id, })
	        	.then(response => {
	        	  this.name = response.data[0];
	        	})
	        },
	  		setYear(){
		  		this.getResults(this.years, this.months, this.ids, this.limit);
		  		//this.$refs.ids.focus();
	  		},
	  		setMonth(){
		  		this.getResults(this.years, this.months, this.ids, this.limit);
		  		//this.$refs.years.focus();
	  		},
	  		setIds(){
		  		this.getResults(this.years, this.months, this.ids, this.limit);
		  		this.getEmployees(this.ids)
				},
				setPeriod(){
		  		this.getResults(this.years, this.months, this.ids, this.limit);
		  		this.getEmployees(this.ids)
	  		},
	  		printer(){
					this.loading = !this.loading;
	  			axios.post('printer',{ 
						searchYear: this.years,
						searchMonth: this.months,
						cats: this.ids,
						limit: this.limit
					})
	  			.then(response => {
						 this.loading = !this.loading;
						 window.open("/pdf") 
	  			})

	  			 
	  		}      
	    }
	}

	// select dtr.fempidno,dtr.fdate,famin,famout,fpmin,fpmout,dtr.funder,fremks,FLAST,FFIRST from dtr left join employee on dtr.fempidno=employee.fempidno where dtr.fempidno = $P{title} and year(dtr.fdate)=$P{fyear} and month(dtr.fdate)=$P{fmonth} limit $P!{taman}
</script>

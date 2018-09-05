<template>
	<div class="col-md-8 col-md-offset-2">
		<div class="form-group col-md-2">
			<input ref="months" maxlength="2" v-model="months" v-on:keyup.enter="setMonth"  placeholder="Month" class="form-control">
		</div>
		<div class="form-group col-md-2">
			<input ref="years" maxlength="4" v-model="years" v-on:keyup.enter="setYear"  placeholder="Year" class="year form-control">
		</div>
		<div class="form-group col-md-2">
			<button class="btn btn-sm btn-primary" @click="printer()" ><span class="fa fa-print"></span> Print</button>
		</div>
		<div class="form-group col-md-12">
			<span v-if="loading"><i class="text-primary fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i></span>
			<label for="first_name" class="column is-2">Name :</label> {{ name.FLAST }}, {{ name.FFIRST }} {{ name.FMI }}
		</div>
	</div>
</template>
<script>
	export default{
	  data(){
	    return{
	      lists:{},
	      loading: false, //variable for loading when deleting
	      temp: '',
	      years : '',
	      months : '',
	      name:{},
	    }
	  },
	  mounted(){
	  		this.getResults(this.years, this.months, this.ids);
	  },
	  methods:{

	        getResults(year, month) {
	          this.loading = !this.loading
	            axios.post('getDtr', { searchYear: year,searchMonth: month, })
	            .then(response => {
	              this.loading = !this.loading;
	              this.lists = response.data;
	              this.$parent.$children[1].lists = response.data;
	              this.$parent.$children[1].months = this.months;
	              this.$parent.$children[1].years = this.years;

	              this.temp = this.lists.filter((item) => {

	              	let string = String(item["fdate"])
	              		
	              		return string.substring(8,10) 
	              })

	             
	            })
	        },
	        getEmployees(id){
	        	axios.post('getEmployee')
	        	.then(response => {
	        	  this.name = response.data[0];
	        	})
	        },
	  		setYear(){
		  		this.getResults(this.years, this.months);
		  		//this.$refs.ids.focus();
	  		},
	  		setMonth(){
		  		this.getResults(this.years, this.months);
		  		//this.$refs.years.focus();
	  		},
	  		setIds(){
		  		this.getResults(this.years, this.months);
		  		//this.$refs.ids.focus();
		  		//this.$refs.ids.select();
	  		},
	  		printer(){
	  			axios.post('printer',{ searchYear: this.years,searchMonth: this.months, })
	  			.then(response => {
	  			 	
	  			})
	  			console.log('a');
	  			window.location.href = "pdf";
	  		}     
	    }
	}
</script>
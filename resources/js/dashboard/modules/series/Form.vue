<template>
	<form @submit.prevent="onSubmit">
		<div class="form-group">
			<div class="row">
				<label for="name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="text" id="name" name="name" v-model="name" class="form-control">
				</div>
			</div>
			<div class="row">
				<label for="description" class="col-sm-2 col-form-label">Description</label>
				<div class="col-sm-10">
					<textarea id="description" name="description" v-model="desc" class="form-control" rows='2'>
					</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<button type="submit" class="btn btn-success form-control">Add</button>
				</div>
			</div>
		</div>
	</form>
</template>

<script>

export default {
	data () {
		return {
			name:"",
			desc:""
		}
	},
	methods: {
		onSubmit() {
			this.$http.post('series/new',{
				name:this.name,
				description:this.desc
			})
			.then((response) => {
				toastr.success('Series Created!')

				this.$emit('reload')
			}).catch(({ response }) => {
				toastr.error(response.status + ' : Resource ' + response.statusText)
			})
		}
	}
}
</script>

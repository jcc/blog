<template>
	<div>
		<div class="row">
			<vue-table :title="$t('page.series')" :fields="fields" api-url="series" :item-actions="itemActions" @table-action="tableActions" show-paginate>
				<template slot="buttons">
					<router-link :to="{ name: 'dashboard.series.create' }" class="btn btn-sm btn-success" v-if="checkPermission('CREATE_SERIES')">{{ $t('page.create') }}</router-link>
				</template>
			</vue-table>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			fields: [{
				name: 'id',
				trans: 'table.id',
				titleClass: 'width-5-percent text-center',
				dataClass: 'text-center'
			}, {
				name: 'name',
				trans: 'table.name',
				sortField: 'name',
			}, {
				name: 'created_at',
				trans: 'table.created_at',
				titleClass: 'width-10-percent',
				sortField: 'created_at'
			}, {
				name: '__actions',
				trans: 'table.action',
				titleClass: 'text-center width-20-percent',
				dataClass: 'text-center',
			}
		],
		itemActions: [
			{ name: 'view-item', icon: 'fas fa-eye', class: 'btn btn-success' },
			{ name: 'edit-item', permission: 'UPDATE_SERIES', icon: 'fas fa-pencil-alt', class: 'btn btn-info' },
			{ name: 'delete-item', permission: 'DESTROY_SERIES', icon: 'fas fa-trash-alt', class: 'btn btn-danger' }
		]
	}

},
methods: {
	tableActions(action, data) {
		if (action == 'edit-item') {
			this.$router.push({ name: 'dashboard.series.edit', params: { id: data.id } })
		} else if (action == 'delete-item') {
			this.$http.delete('series/' + data.id)
			.then((response) => {
				toastr.success('You delete the series!')

				this.$emit('reload')
			}).catch(({ response }) => {
				if ((typeof response.data.error !== 'string') && response.data.error) {
					toastr.error(response.data.error.message)
				} else {
					toastr.error(response.status + ' : Resource ' + response.statusText)
				}
			})
		} else if (action == 'view-item') {
			window.open('/series/' + data.id, '_blank');
		}
	},
}
}
</script>

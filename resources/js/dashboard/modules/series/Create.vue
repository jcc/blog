<template>
	<vue-form :title="$t('form.create_series')">
		<template slot="buttons">
			<router-link :to="{ name: 'dashboard.series' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
		</template>
		<template slot="content">
			<series-form></series-form>
		</template>
	</vue-form>
</template>

<script>
import SeriesForm from './Form'

export default {
	components: { SeriesForm },
}
</script>

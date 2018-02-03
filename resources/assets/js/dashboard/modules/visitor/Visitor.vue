<template>
    <div class="row">
        <vue-table :title="$t('page.visitors')" :fields="fields" api-url="visitor" show-paginate></vue-table>
    </div>
</template>

<script>
export default {
    data () {
        return {
            fields: [
                {
                    name: 'id',
                    trans: 'table.id',
                    titleClass: 'width-5-percent text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'article',
                    trans: 'table.article_title',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'article'
                },
                {
                    name: "ip",
                    trans: 'table.ip'
                },
                {
                    name: 'clicks',
                    trans: 'table.click_num'
                },
                {
                    name: 'created_at',
                    trans: 'table.created_at'
                }
            ]
        };
    },
    methods: {
        article(value) {
            return value.title
        }
    }
}
</script>

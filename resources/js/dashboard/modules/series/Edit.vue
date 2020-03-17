<template>
	<div id="edit-wrap">
		<div class='text-center'>

				<form @submit.prevent="updateInfo">
					<div class="form-group" id="info-form-wrap">
						<div class="row">
							<label for="name" class="col-sm-2 col-form-label">Name</label>
							<div class="col-sm-10">
								<input type="text" id="series-name" name="name" class="form-control">
							</div>
						</div>
						<div class="row">
							<label for="description" class="col-sm-2 col-form-label">Description</label>
							<div class="col-sm-10">
								<textarea id="series-desc" name="description" class="form-control" rows='2'>
								</textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 offset-6 text-right">
								<button type="submit" class="btn btn-success form-control d-inline">Update</button>
							</div>
						</div>
					</div>
				</form>
		</div>
		<br><hr><br>
		<div>
			<h3 class='text-center'>Articles:</h3>
			<div id='articles-list'>
				<draggable v-model="articles" @start="drag=true" @end="drag=false">
					<div class='row article-wrap' v-for="art in articles" :key="art.id">
						<div class='col-10'>
							<span class="article">{{art.title}}</span>
						</div>
						<div class='col-2 text-right'>
							<button @click="deleteArticle(art.id)" class='btn btn-danger d-inline'>Remove</button>
						</div>
					</div>
				</draggable>
			</div>
			<div id='new-article-wrap' v-if="articles_available.length>0">
				<div class='row'>
					<div class='col-10'>
						<select id='new-art-select' class="form-control form-control-lg">
							<option class='add-art-option' value="0">None</option>
							<option v-for="art in articles_available" :key="art.id" :id='"option-"+art.id' class="add-art-option" :value="art.id" v-text="art.title"></option>
						</select>
					</div>
					<div class='col-2'>
						<button @click="addArticle()" class='btn btn-primary'>Add</button>
					</div>
				</div>
			</div>
			<div class='text-center'>
				<button class='btn btn-success d-inline' @click="updateSeries">Update Articles</button>
			</div>
		</div>
	</div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
	components: {
		draggable,
	},
	data() {
		return {
			series: undefined,
			articles:[],
			articles_available:[],
		}
	},
	created() {
		this.$http.get('series/edit/' + this.$route.params.id)
		.then((response) => {
			this.series = response.data.series;
			this.articles = this.series.articles;
			// debugger
			this.articles_available = response.data.articles_available;
			$('#series-name').val(this.series.name);
			$('#series-desc').val(this.series.description);
		})
	},
	methods: {
		addArticle() {
			var article_id = $('#new-art-select').val();
			if (article_id == 0) {
				return;
			}
			var article;
			this.articles_available.forEach(function(art,ind) {
				if (art.id == article_id) {
					article = art;
					return;
				}
			});
			this.articles.push(article);
			$('#option-'+article_id).css('display','none');
			$('#new-art-select').val(0);
		},
		deleteArticle(id) {
			var index_to_remove;
			this.articles.forEach(function(art,ind) {
				if (art.id == id) {
					index_to_remove = ind;
					return;
				}
			});
			this.articles.splice(index_to_remove,1);
		},
		updateSeries() {
			let new_articles = this.articles.map(({ id }) => id);
			console.log()
			this.$http.patch('series/order/' + this.$route.params.id, {articles:new_articles})
			.then((response) => {
				toastr.success('Series updated!')
			})
		},
		updateInfo() {
			this.$http.patch('series/' + this.$route.params.id, {
				name:$('#series-name').val(),
				description:$('#series-desc').val()
			})
			.then((response) => {
				toastr.success('Series updated!')
			})
		}

	}
}
</script>
<style>
#articles-list, #new-article-wrap {
	width:80%;
	margin:auto;
}
#articles-list .article-wrap {
	border:1px solid black;
	background-color:white;
	box-shadow:0px 0px 3px black;
	margin:3px 0px;
	width:100%;
	padding:5px;
	font-size:18px;
	border-radius:5px;
}
#edit-wrap {
	margin:20px 0px;
}
#series-name, #series-desc{
	width:75%;
}


</style>

<?php

namespace App\Http\Controllers\Api;

use \App\Series;
use \App\Article;
use Illuminate\Http\Request;

class SeriesController extends ApiController
{
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		$keyword = $request->get('keyword');

		$seriess = Series::checkAuth()
		->when($keyword, function ($query) use ($keyword) {
			$query->where('title', 'like', "%{$keyword}%");
		})
		->orderBy('created_at', 'desc')->paginate(10);

		return $this->response->collection($seriess);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		//
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'name' => 'required|max:140',
			'description' => 'required|max:280',
		]);
		Series::create($validatedData);
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Series $series)
	{

		return [
			"articles_available"=>Article::where(['series_id'=>null])->get(),
			"series"=>$series->load('articles')
		];
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, Series $series)
	{
		$validatedData = $request->validate([
			'name' => 'required|max:140',
			'description' => 'required|max:280',
		]);
		$series->update($validatedData);
	}

	public function updateOrder(Request $request, Series $series) {
		// reset all articles in this series
		$series->articles()->update([
			'series_id'=>null,
			'number_in_series'=>null
		]);
		foreach (request()->articles as $key => $a) {
			Article::find($a)->update([
				'series_id'=>$series->id,
				'number_in_series'=>$key+1
			]);
		}
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Series $series)
	{
		// reset all articles in this series
		$series->articles()->update([
			'series_id'=>null,
			'number_in_series'=>null
		]);
		$series->delete();

	}

	public function addArticle(Series $series, Article $article) {
		$series->add($article);
	}
	public function destroyArticle(Series $series, Article $article) {
		$series->remove($article);
	}
}

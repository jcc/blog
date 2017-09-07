<div class="container list">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @forelse($articles as $article)
            <div class="media">
                @if($article->page_image)
                <a class="media-left" href="{{ url($article->slug) }}">
                    <img alt="{{ $article->slug }}" src="{{ $article->page_image }}?imageView2/1/w/640/h/480/format/webp/interlace/1/q/100|watermark/2/text/5aSP5aSp55qE6aOO/font/5b6u6L2v6ZuF6buR/fontsize/240/fill/I0ZGRkZGRg==/dissolve/80/gravity/SouthEast/dx/10/dy/10|imageslim" data-holder-rendered="true">
                </a>
                @endif
                <div class="media-body">
                    <h6 class="media-heading">
                        <a href="{{ url($article->slug) }}">
                            {{ $article->title }}
                        </a>
                    </h6>
                    <div class="meta">
                        <span class="cinema">{{ $article->subtitle }}</span>
                    </div>
                    <div class="description">
                        {{ $article->meta_description }}
                    </div>
                    <div class="extra">
                        @foreach($article->tags as $tag)
                        <a href="{{ url('tag', ['tag' => $tag->tag]) }}">
                            <div class="label"><i class="ion-pricetag"></i>{{ $tag->tag }}</div>
                        </a>
                        @endforeach

                        <div class="info">
                            <i class="ion-person"></i>{{ $article->user->name or 'null' }}&nbsp;&nbsp;
                            <i class="ion-clock"></i>{{ $article->published_at->diffForHumans() }}&nbsp;&nbsp;
                            <i class="ion-ios-eye"></i>{{ $article->view_count }}
                            <a href="{{ url($article->slug) }}" class="pull-right">
                                {{lang('Read More')}} <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <h3 class="text-center">{{ lang('Nothing') }}</h3>
            @endforelse
        </div>
    </div>
</div>
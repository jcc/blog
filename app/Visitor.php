<?php

namespace App;

class Visitor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip',
        'article_id',
        'clicks',
    ];

    /**
     * Get the article for visitor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * 记录访问记录.
     *
     * @author Huiwang <905130909@qq.com>
     *
     * @param $articleId
     * @param $ip
     *
     * @return Visitor|Model|null|object
     */
    public static function log($articleId, $ip)
    {
        $log = self::query()->where('article_id', $articleId)->where('ip', $ip)->first();
        if ($log) {
            $log->increment('clicks');
        } else {
            $data = [
                'ip' => $ip,
                'article_id' => $articleId,
                'clicks' => 1,
            ];
            $log = self::create($data);
        }

        return $log;
    }
}

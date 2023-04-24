<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date', 'is_favorited', 'favorites_count', 'body_html'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = clean($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return "";
    }

    // public function getStatusAttribute()
    // {
    //     if ($this->answers_count > 0) {
    //         if ($this->best_answer_id) {
    //             return "answered-accepted";
    //         }
    //         return "answered";
    //     }
    //     return "unanswered";
    // }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    // public function acceptBestAnswer(Answer $answer)
    // {
    //     $this->best_answer_id = $answer->id;
    //     $this->save();
    // }

    // public function favorites()
    // {
    //     return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //, 'question_id', 'user_id');
    // }

    // public function isFavorited()
    // {
    //     return $this->favorites()->where('user_id', 1)->count() > 0;
    // }

    // public function getIsFavoritedAttribute()
    // {
    //     return $this->isFavorited();
    // }

    // public function getFavoritesCountAttribute()
    // {
    //     return $this->favorites->count();
    // }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getTimeAgo($carbonObject) {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w'],
            $carbonObject->diffForHumans()
        );
    }

    // -------------------------------------------- Đã sửa -------------------------------------------------

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            $question->likes()->delete();
            $question->answers->each(function ($answer) {
                $answer->likes()->delete();
            });
        });
    }

    // Có thể bỏ
    // public function getLikesCountAttribute()
    // {
    //     return $this->likes()->count();
    // }

    // public function getAnswersCountAttribute()
    // {
    //     return $this->answers()->count();
    // }

    // public function getViewsCountAttribute()
    // {
    //     $this->views->count();
    // }

    // public function getRouteKeyName() {
    //     return 'slug';
    // }
}

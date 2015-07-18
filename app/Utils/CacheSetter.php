<?php

namespace App\Utils;

use App\Utils\BiliGetter;
use Illuminate\Support\Facades\Cache;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/15
 * Time: 下午7:11
 */
class CacheSetter
{
    //刷新缓存
    public static function freshCache()
    {
        date_default_timezone_set('PRC');

        $list_index = BiliGetter::getIndex();
        $list_news = BiliGetter::getDaily();

        Cache::forever(GlobalVar::$INDEX_LIST_CACHE, $list_index);
        Cache::forever(GlobalVar::$NEW_LIST_CACHE, $list_news);
        Cache::forever(GlobalVar::$UPDATE_TIME, date('H:m:s'));
    }

    //清除缓存
    public static function deleteCache()
    {
        if (CacheSetter::hasCache()) {
            Cache::forget(GlobalVar::$INDEX_LIST_CACHE);
            Cache::forget(GlobalVar::$NEW_LIST_CACHE);
            Cache::forget(GlobalVar::$UPDATE_TIME);
        }
    }

    //判断缓存
    public static function hasCache()
    {
        if (Cache::has(GlobalVar::$INDEX_LIST_CACHE) && Cache::has(GlobalVar::$NEW_LIST_CACHE) && (Cache::has(GlobalVar::$UPDATE_TIME))) {
            return true;
        } else {
            return false;
        }
    }


    public static function getIndex()
    {
        if (!CacheSetter::hasCache()) {
            CacheSetter::freshCache();
        }
        return Cache::get(GlobalVar::$INDEX_LIST_CACHE);
    }


    public static function getNews()
    {
        if (!CacheSetter::hasCache()) {
            CacheSetter::freshCache();
        }
        return Cache::get(GlobalVar::$NEW_LIST_CACHE);
    }


    public static function getTime()
    {
        if (!CacheSetter::hasCache()) {
            CacheSetter::freshCache();
        }
        return Cache::get(GlobalVar::$UPDATE_TIME);
    }

}
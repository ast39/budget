<?php

namespace App\Classes;

use Illuminate\Support\Arr;
use mysql_xdevapi\SqlStatement;

class CategoryTree {

    /**
     * @param array $data
     * @return array
     */
    public static function getProfitTree(array $data): array
    {
        $data = Arr::where($data, function($e) {
            return $e['type'] == 1;
        });

        $data = Arr::sort($data, function($e) {
            return $e['parent_cat_id'];
        });

        $tree = [];

        foreach ($data as $item) {

            if (is_null($item['parent_cat_id'])) {

                $tree[$item['cat_id']] = $item;
            } else {

                if (!key_exists('child', $tree[$item['parent_cat_id']])) {
                    $tree[$item['parent_cat_id']]['child'] = [];
                }

                $tree[$item['parent_cat_id']]['child'][] = $item;
            }
        }

        return self::sortable($tree);
    }

    /**
     * @param array $data
     * @return array
     */
    public static function getWdTree(array $data): array
    {
        $data = Arr::where($data, function($e) {
            return $e['type'] == 2;
        });

        $data = Arr::sort($data, function($e) {
            return $e['parent_cat_id'];
        });

        $tree = [];

        foreach ($data as $item) {

            if (is_null($item['parent_cat_id'])) {

                $tree[$item['cat_id']] = $item;
            } else {

                if (!key_exists('child', $tree[$item['parent_cat_id']])) {
                    $tree[$item['parent_cat_id']]['child'] = [];
                }

                $tree[$item['parent_cat_id']]['child'][] = $item;
            }
        }

        return self::sortable($tree);
    }

    protected static function sortable(array $data): array
    {
        foreach ($data as $id => $block) {
            if (key_exists('child', $block)) {
                $data[$id]['child'] = Arr::sort($block['child'], function($e) {
                    return $e['title'];
                });
            }
        }

        return Arr::sort($data, function($e) {
            return $e['title'];
        });
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * offset値を計算
     *
     * @param integer $page 現在のページ
     * @param integer $perPage 1ページあたりの表示件数
     * @return integer offset値
     */
    protected function calcOffset(int $page, int $perPage): int
    {
        return ($page - 1) * $perPage;
    }

    /**
     * ページング情報をview変数に設定
     *
     * @param integer $totalCount 全件数
     * @param integer $page 現在のページ
     * @param integer $limit 最大表示件数
     * @param integer $pageLimit 最大ページ表示件数
     * @param string $viewName 表示viewパス
     * @return void
     */
    protected function paging(int $totalCount, int $page, int $limit, int $pageLimit, string $viewName = 'index'): void
    {
        // 総ページ数を計算
        $pageTotal = ceil($totalCount / $limit);
        // 最大ページサイズより大きい数字が選択された場合のチェック
        if ($pageTotal < $page) {
            $page = $pageTotal;
        }
        // ページングの変数を処理
        list($prev, $next, $numbers) = $this->createPagenateSettings($totalCount, $page, $limit, $pageLimit);
        // view変数に設定
        view($viewName, array(
            // 現在のページ番号
            'page' => $page,
            // 全ページ数
            'page_total' => $pageTotal,
            // 全件数
            'total_count' => $totalCount,
            // 1ページあたりの表示件数
            'limit' => $limit,
            'prev' => $prev,
            'next' => $next,
            // 表示番号
            'numbers' => $numbers
        ));
    }

    /**
     * ページネーションパラメータ配列を取得
     *
     * @param integer $totalCount 全件数
     * @param integer $page 現在のページ
     * @param integer $limit 最大表示件数
     * @param integer $pageLimit 最大ページ表示件数
     * @return array [前ページ情報配列, 次ページ情報配列, ページング表示番号リスト]
     */
    private function createPagenateSettings(int $totalCount, int $page, int $limit, int $pageLimit): array
    {
        // 0件の場合は、空を返す
        if (empty($totalCount)) {
            return [
                array(), array(), []
            ];
        }
        // 前のページ情報
        $prev_num = $limit;
        $prev = array(
            'prev_num' => $prev_num,
            'prev_title' => '前の' . $prev_num . '件',
            'prev_exist_flg' => ($page === 1) ? false : true
        );
        // 次のページ情報
        $remaining = $totalCount - ($limit * $page);
        $next_num = ($remaining > $limit) ? $limit : $remaining;
        $next = array(
            'next_num' => $next_num,
            'next_title' => '前の' . $next_num . '件',
            'next_exist_flg' => ($next_num <= 0) ? false : true
        );
        // ページング表示番号を生成
        $numbers = $this->createPagenateNumbers($totalCount, $page, $limit, $pageLimit);

        return [$prev, $next, $numbers];
    }

    /**
     * ページング表示番号を生成
     *
     * @param integer $totalCount 全件数
     * @param integer $page 現在のページ
     * @param integer $limit 最大表示件数
     * @param integer $pageLimit 最大ページ表示件数
     * @return array ページング表示番号リスト
     */
    private function createPagenateNumbers(int $totalCount, int $page, int $limit, int $pageLimit): array
    {
        // 戻り値:ページ番号リスト
        $numbers = [];
        // ループ初期値を初期化
        $initLoopVal = 1;
        // ループ最終値を初期化
        $lastLoopVal = $pageLimit;
        // 中央値
        $median = floor($pageLimit / 2);
        // ページ総数
        $chunkNumber = ceil($totalCount / $limit);
        // ページ数がページングの表示最大値より下の場合
        if ($chunkNumber <= $pageLimit) {
            // ループ最終値を設定
            $lastLoopVal = $chunkNumber;
        } else {
            // 最初のページング制御
            // 現在のページが中央値以下の場合
            if ($page <= $median) {
                // 中央値が「1」以外の場合は、ページングの表示最大値を最大値に設定
                // 中央値が「1」の場合は、ページングの表示最大値に中央値を加算
                $lastLoopVal = ($median !== 1) ? $pageLimit : $pageLimit + $median;
            }
            // 最後のページング制御
            // 全ページ数-現在のページが中央値以下の場合
            else if ($chunkNumber - $page <= $median) {
                // 全ページ数-ページングの表示最大値をループ初期値に設定
                $initLoopVal = $chunkNumber - $pageLimit;
                // 全ページ数をループ最終値に設定
                $lastLoopVal = $chunkNumber;
            }
            // 上記以外
            else {
                // 現在のページ番号-中央値をループ初期値に設定
                $initLoopVal = $page - $median;
                // 現在のページ番号+中央値をループ最終値に設定
                $lastLoopVal = $page + $median;
            }
        }
        for ($i = $initLoopVal; $i <= $lastLoopVal; $i++) {
            $numbers[] = $i;
        }
        return $numbers;
    }
}

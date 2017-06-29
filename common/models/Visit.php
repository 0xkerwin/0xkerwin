<?php 

namespace common\models;

use Yii;

/**
* 
*/
class Visit
{
    /**
     * 统计访问量
     * @return [type] [description]
     */
    public static function visit()
    {
        $redis = \Yii::$app->redis;
        $redis_keys = \Yii::$app->params['redisKeys'];  //keys前缀
        $date = date('Ymd', time());
        $visit_ip = $_SERVER["REMOTE_ADDR"];

        $redis->lpush($redis_keys['visit'].$date, $visit_ip);

        return true;
    }

    /**
     * 访问量
     * @param  string $date_type   日期范围类型
     *                             'a_week': 一周
     *                             'three_week': 三周
     *                             'one_month': 一个月
     *                             'three_month': 三个月
     *                             'half_year': 半年
     *                             'one_year': 一年
     *                             'search': 自定义时间
     * @param  array  $search_date 搜索时间范围
     * @return json              返回日期与访问量
     */
    public function getPageViews($date_type = 'a_week', $search_date=[])
    {
        $data = $this->getVisitNum('pv', $date_type, $search_date);

        return $data;
    }

    /**
     * 独立访问量
     * @param  string $date_type   日期范围类型
     * @param  array  $search_date 搜索时间范围
     * @return json              返回日期与独立访问量
     */
    public function getUniqueVisitor($date_type = 'a_week', $search_date=[])
    {
        $data = $this->getVisitNum('uv', $date_type, $search_date);

        return $data;
    }

    /**
     * 从redis获取数据
     * @param  string $type   访问类型 (pv: 访问量; uv: 独立访问量)
     * @param  string $date_type   日期范围类型
     * @param  array  $search_date 搜索时间范围
     * @return array              返回日期与访问量
     */
    public function getVisitNum($type, $date_type, $search_date=[])
    {
        if ($date_type != 'search') {
            $date = $this->getTime($date_type);
        }else {
            $date['start_date'] = isset($search_date['start_date']) ? $search_date['start_date'] : '';
            $date['end_date'] = isset($search_date['end_date']) ? $search_date['end_date'] : '';
        }

        $redis = \Yii::$app->redis;
        $redis_keys = \Yii::$app->params['redisKeys'];  //keys前缀

        $start_date = $date['start_date'];
        $date_arr = array($this->formatDate($start_date));
        $visit_num = array();

        //第一天
        if ($type == 'pv') {
            //访问量
            $visit_num[] = $redis->llen($redis_keys['visit'].$start_date);
        }else{
            //独立访问量（需要去重）
            $visit_ip = $redis->lrange($redis_keys['visit'].$start_date, 0, -1);
            $unique_views = array_unique($visit_ip);
            $visit_num[] = count($unique_views);
        }

        //多天
        while (strtotime($start_date) < strtotime($date['end_date'])) {
            $start_date = date('Ymd', strtotime($start_date.'+1 day'));
            $date_arr[] = $this->formatDate($start_date);

            if ($type == 'pv') {
                $visit_num[] = $redis->llen($redis_keys['visit'].$start_date);
            }else{
                $visit_ip = $redis->lrange($redis_keys['visit'].$start_date, 0, -1);
                $unique_views = array_unique($visit_ip);
                $visit_num[] = count($unique_views);
            }
        }

        $data = ['date' => $date_arr, 'visit' => $visit_num];

        return $data;
    }

    /**
     * 获取快捷时间范围
     * @param  string $type       日期范围类型
     * @return array             返回开始日期和结束日期
     */
    public function getTime($type)
    {
        $date = array();

        switch ($type) {
            case 'a_week':
                $start_date = date('Ymd', strtotime('-6 days'));
                break;

            case 'three_week':
                $start_date = date('Ymd', strtotime('-21 days'));
                break;

            case 'one_month':
                $start_date = date('Ymd', strtotime('-1 month'));
                break;

            case 'three_month':
                $start_date = date('Ymd', strtotime('-3 month'));
                break;

            case 'half_year':
                $start_date = date('Ymd', strtotime('-6 month'));
                break;

            case 'one_year':
                $start_date = date('Ymd', strtotime('-1 year'));
                break;
            
            default:
                $start_date = date('Ymd', time());
                break;
        }

        $date['start_date'] = $start_date;
        $date['end_date'] = date('Ymd', time());

        return $date;
    }

    /**
     * 格式化日期：年-月-日
     * @param  string $date 日期：年月日
     * @return string       年-月-日
     */
    public function formatDate($date)
    {
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $days = substr($date, -2);

        return $year.'-'.$month.'-'.$days;
    }
}
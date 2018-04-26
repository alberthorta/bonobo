<?php

namespace Alberthorta\Bonobo\Report;

class ListStats {
    protected $list_stats_data;

    /**
     * ListStats constructor.
     * @param $list_stats_data
     */
    public function __construct($list_stats_data) {
        $this->list_stats_data = $list_stats_data;
    }

    /**
     * @return float
     */
    public function getSubRate() {
        return $this->list_stats_data->sub_rate;
    }

    /**
     * @return float
     */
    public function getUnsubRate() {
        return $this->list_stats_data->unsub_rate;
    }

    /**
     * @return float
     */
    public function getOpenRate() {
        return $this->list_stats_data->open_rate;
    }

    /**
     * @return float
     */
    public function getClickRate() {
        return $this->list_stats_data->click_rate;
    }
}
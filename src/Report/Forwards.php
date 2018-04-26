<?php

namespace Alberthorta\Bonobo\Report;

class Forwards {
    protected $forwards_data;

    /**
     * Forwards constructor.
     * @param $forwards_data
     */
    public function __construct($forwards_data) {
        $this->forwards_data = $forwards_data;
    }

    /**
     * @return int
     */
    public function getForwardsCount() {
        return $this->forwards_data->forwards_count;
    }

    /**
     * @return int
     */
    public function getForwardsOpens() {
        return $this->forwards_data->forwards_opens;
    }
}
<?php

namespace Alberthorta\Bonobo\Report;

class Bounces {
    protected $bounces_data;

    /**
     * Bounces constructor.
     * @param $bounces_data
     */
    public function __construct($bounces_data) {
        $this->bounces_data = $bounces_data;
    }

    /**
     * @return int
     */
    public function getHardBounces() {
        return $this->bounces_data->hard_bounces;
    }

    /**
     * @return int
     */
    public function getSoftBounces() {
        return $this->bounces_data->soft_bounces;
    }

    /**
     * @return int
     */
    public function getSyntaxErrors() {
        return $this->bounces_data->syntax_errors;
    }
}
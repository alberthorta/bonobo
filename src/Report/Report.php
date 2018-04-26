<?php

namespace Alberthorta\Bonobo\Report;

class Report {
    protected $report_data;

    /**
     * Report constructor.
     * @param $report_data
     */
    public function __construct($report_data) {
        $this->report_data = $report_data;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->report_data->id;
    }

    /**
     * @return string
     */
    public function getCampaignTitle() {
        return $this->report_data->campaign_title;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->report_data->type;
    }

    /**
     * @return string
     */
    public function getListId() {
        return $this->report_data->list_id;
    }

    /**
     * @return bool
     */
    public function getListIsActive() {
        return $this->report_data->list_is_active;
    }

    /**
     * @return string
     */
    public function getListName() {
        return $this->report_data->list_name;
    }

    /**
     * @return string
     */
    public function getSubjectLine() {
        return $this->report_data->subject_line;
    }

    /**
     * @return string
     */
    public function getPreviewText() {
        return $this->report_data->preview_text;
    }

    /**
     * @return int
     */
    public function getEmailsSent() {
        return $this->report_data->emails_sent;
    }

    /**
     * @return int
     */
    public function getAbuseReports() {
        return $this->report_data->abuse_reports;
    }

    /**
     * @return int
     */
    public function getUnsubscribed() {
        return $this->report_data->unsubscribed;
    }

    /**
     * @return \DateTime
     */
    public function getSendTime() {
        return new \DateTime($this->report_data->send_time);
    }

    /**
     * @return Bounces
     */
    public function getBounces() {
        return new Bounces($this->report_data->bounces);
    }

    /**
     * @return Forwards
     */
    public function getForwards() {
        return new Forwards($this->report_data->forwards);
    }

    /**
     * @return Opens
     */
    public function getOpens() {
        return new Opens($this->report_data->opens);
    }

    /**
     * @return Clicks
     */
    public function getClicks() {
        return new Clicks($this->report_data->clicks);
    }

    /**
     * @return FacebookLikes
     */
    public function getFacebookLike() {
        return new FacebookLikes($this->report_data->facebook_likes);
    }

    /**
     * @return ListStats
     */
    public function getListStats() {
        return new ListStats($this->report_data->list_stats);
    }

    /**
     * @return TimeseriesElement[]
     */
    public function getTimeseries() {
        return array_map(function($element) {
            return new TimeseriesElement($element);
        }, $this->report_data->timeseries);
    }

    /**
     * @return Ecommerce
     */
    public function getEcommerce() {
        return new Ecommerce($this->report_data->ecommerce);
    }

    /**
     * @return DeliveryStatus
     */
    public function getDeliveryStatus() {
        return new DeliveryStatus($this->report_data->delivery_status);
    }
}
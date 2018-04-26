<?php

namespace Alberthorta\Bonobo\MailingList;

class MailingListStats {
    protected $list_stats;

    public function __construct($list_stats) {
        $this->list_stats = $list_stats;
    }

    /**
     * @return int
     */
    public function getMemberCount() {
        return $this->list_stats->member_count;
    }

    /**
     * @return int
     */
    public function getUnsubscribeCount() {
        return $this->list_stats->unsubscribe_count;
    }

    /**
     * @return int
     */
    public function getCleanedCount() {
        return $this->list_stats->cleaned_count;
    }

    /**
     * @return int
     */
    public function getMemberCountSinceSend() {
        return $this->list_stats->member_count_since_send;
    }

    /**
     * @return int
     */
    public function getUnsubscribeCountSinceSend() {
        return $this->list_stats->unsubscribe_count_since_send;
    }

    /**
     * @return int
     */
    public function getCleanedCountSinceSend() {
        return $this->list_stats->cleaned_count_since_send;
    }

    /**
     * @return int
     */
    public function getCampaignCount() {
        return $this->list_stats->campaign_count;
    }

    /**
     * @return string
     */
    public function getCampaignLastSent() {
        return new \DateTime($this->list_stats->campaign_last_sent);
    }

    /**
     * @return int
     */
    public function getMergeFieldCount() {
        return $this->list_stats->merge_field_count;
    }

    /**
     * @return float
     */
    public function getAvgSubRate() {
        return $this->list_stats->avg_sub_rate;
    }

    /**
     * @return float
     */
    public function getTargetSubRate() {
        return $this->list_stats->target_sub_rate;
    }

    /**
     * @return float
     */
    public function getOpenRate() {
        return $this->list_stats->open_rate;
    }

    /**
     * @return float
     */
    public function getClickRate() {
        return $this->list_stats->click_rate;
    }

    /**
     * @return \DateTime
     */
    public function getLastSubDate() {
        return new \DateTime($this->list_stats->last_sub_date);
    }

    /**
     * @return \DateTime
     */
    public function getLastUnsubDate() {
        return new \DateTime($this->list_stats->last_unsub_date);
    }
}
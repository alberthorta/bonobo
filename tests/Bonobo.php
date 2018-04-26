<?php

use PHPUnit\Framework\TestCase;

use Alberthorta\Bonobo\Bonobo as Bonobo;
use Alberthorta\Bonobo\Exceptions\NoValidKeyException as NoValidKeyException;
use Alberthorta\Bonobo\Exceptions\NoMailingListFound as NoMailingListFound;

class TestBonobo extends TestCase
{
    public static function setUpBeforeClass() {
        (new Dotenv\Dotenv(__DIR__))->load();
    }

    function setUp() {
        parent::setUp();
        \VCR\VCR::turnOn();
        \VCR\VCR::insertCassette($this->getName().".fixture");
    }

    function tearDown() {
        parent::tearDown();
        \VCR\VCR::eject();
    }

    function test_mailchimp_isValidKey_validates_a_valid_key() {
        $this->assertEquals(Bonobo::isValidKey(getEnv("MAILCHIMP_VALID_KEY")), getEnv("MAILCHIMP_VALID_KEY_DATA_CENTER"));
    }

    function test_mailchimp_isValidKey_invalidates_an_invalid_key() {
        $this->assertFalse(Bonobo::isValidKey("6c0cgc2345641c97557abcfdaa0fa8b2-us12"));
    }

    function test_mailchimp_isValidKey_invalidates_an_invalid_long_key() {
        $this->assertFalse(Bonobo::isValidKey("6c0c5c234ff745641c97557abcfdaa0fa8b2-us12"));
    }

    function test_Bonobo_creation_with_invalid_key_throws_exception() {
        $this->expectException(NoValidKeyException::class);
        new Bonobo("6c0cfc2345641c97557abcfdaa0fa8b2-us12");
    }

    function test_Bonobo_creation_with_valid_key_works() {
        $this->assertInstanceOf(Bonobo::class, new Bonobo(getEnv("MAILCHIMP_VALID_KEY")));
    }

    function test_Bonobo_getKey_works_as_expected() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $this->assertEquals(getEnv("MAILCHIMP_VALID_KEY"), $bonobo->getApiKey());
    }

    function test_Bonobo_methods_work_as_expected() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $this->assertInternalType('string', $bonobo->getAccountId());
        $this->assertInternalType('string', $bonobo->getLoginId());
        $this->assertInternalType('string', $bonobo->getAccountName());
        $this->assertInternalType('string', $bonobo->getEmail());
        $this->assertInternalType('string', $bonobo->getFirstName());
        $this->assertInternalType('string', $bonobo->getLastName());
        $this->assertInternalType('string', $bonobo->getUsername());
        $this->assertInternalType('string', $bonobo->getAvatarUrl());
        $this->assertInternalType('string', $bonobo->getRole());
        $this->assertInstanceOf(\DateTime::class, $bonobo->getMemberSince());
        $this->assertInternalType('string', $bonobo->getPricingPlanType());
        $this->assertInstanceOf(\DateTime::class, $bonobo->getFirstPayment());
        $this->assertInstanceOf(\DateTimeZone::class, $bonobo->getAccountTimezone());
        $this->assertInternalType('string', $bonobo->getPricingPlanType());
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\Contact::class, $bonobo->getContact());
        $this->assertInternalType('boolean', $bonobo->getProEnabled());
        $this->assertInstanceOf(\DateTime::class, $bonobo->getLastLogin());
        $this->assertInternalType('integer', $bonobo->getTotalSubscribers());
        $this->assertInstanceOf(\DateTime::class, $bonobo->getLastLogin());
        $this->assertInternalType('array', $bonobo->getLists());
        $this->assertInternalType('array', $bonobo->getListsByName(getEnv('MAILCHIMP_VALID_LIST_NAME')));
        $this->assertInternalType('array', $bonobo->getReports());
    }

    function test_Bonobo_getListByName_throws_exception() {
        $this->expectException(NoMailingListFound::class);
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $this->assertInternalType('array', $bonobo->getListsByName('Not valid list name'));
    }

    function test_Bonobo_Contact_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\Contact::class, $bonobo->getContact());
        $contact = $bonobo->getContact();
        $this->assertInternalType('string', $contact->getCompany());
        $this->assertInternalType('string', $contact->getAddress1());
        $this->assertInternalType('string', $contact->getAddress2());
        $this->assertInternalType('string', $contact->getCity());
        $this->assertInternalType('string', $contact->getState());
        $this->assertInternalType('string', $contact->getZip());
        $this->assertInternalType('string', $contact->getCountry());
    }

    function test_Bonobo_MailingList_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $lists = $bonobo->getListsByName(getEnv('MAILCHIMP_VALID_LIST_NAME'));
        $this->assertInternalType('array', $lists);
        $this->assertNotEmpty($lists);
        $list = current($lists);
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\MailingList::class, $list);
        $this->assertInternalType('string', $list->getId());
        $this->assertInternalType('integer', $list->getWebId());
        $this->assertInternalType('string', $list->getName());
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\Contact::class, $list->getContact());
        $this->assertInternalType('string', $list->getPermissionReminder());
        $this->assertInternalType('boolean', $list->getUseArchiveBar());
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\CampaignDefaults::class, $list->getCampaignDefaults());
        $this->assertInternalType('string', $list->getNotifyOnSubscribe());
        $this->assertInternalType('string', $list->getNotifyOnUnsubscribe());
        $this->assertInstanceOf(\DateTime::class, $list->getDateCreated());
        $this->assertThat($list->getListRating(), $this->logicalOr(
           $this->isType('int'),
           $this->isType('float')
        ));
        $this->assertInternalType('boolean', $list->getEmailTypeOption());
        $this->assertInternalType('string', $list->getSubscribeUrlShort());
        $this->assertInternalType('string', $list->getSubscribeUrlLong());
        $this->assertInternalType('string', $list->getBeamerAddress());
        $this->assertInternalType('string', $list->getVisibility());
        $this->assertInternalType('boolean', $list->getDoubleOptin());
        $this->assertInternalType('array', $list->getModules());
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\MailingListStats::class, $list->getStats());
    }

    function test_Bonobo_CampaignDefaults_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $lists = $bonobo->getListsByName(getEnv('MAILCHIMP_VALID_LIST_NAME'));
        $this->assertInternalType('array', $lists);
        $this->assertNotEmpty($lists);
        $list = current($lists);
        $campaignDefaults = $list->getCampaignDefaults();
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\CampaignDefaults::class, $campaignDefaults);
        $this->assertInternalType('string', $campaignDefaults->getFromName());
        $this->assertInternalType('string', $campaignDefaults->getFromEmail());
        $this->assertInternalType('string', $campaignDefaults->getSubject());
        $this->assertInternalType('string', $campaignDefaults->getLanguage());
    }

    function test_Bonobo_MailingListStats_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $lists = $bonobo->getListsByName(getEnv('MAILCHIMP_VALID_LIST_NAME'));
        $this->assertInternalType('array', $lists);
        $this->assertNotEmpty($lists);
        $list = current($lists);
        $mailing_list_stats = $list->getStats();
        $this->assertInstanceOf(Alberthorta\Bonobo\MailingList\MailingListStats::class, $mailing_list_stats);
        $this->assertInternalType('integer', $mailing_list_stats->getMemberCount());
        $this->assertInternalType('integer', $mailing_list_stats->getUnsubscribeCount());
        $this->assertInternalType('integer', $mailing_list_stats->getCleanedCount());
        $this->assertInternalType('integer', $mailing_list_stats->getMemberCountSinceSend());
        $this->assertInternalType('integer', $mailing_list_stats->getUnsubscribeCountSinceSend());
        $this->assertInternalType('integer', $mailing_list_stats->getCleanedCountSinceSend());
        $this->assertInternalType('integer', $mailing_list_stats->getCampaignCount());
        $this->assertInstanceOf(\DateTime::class, $mailing_list_stats->getCampaignLastSent());
        $this->assertInternalType('integer', $mailing_list_stats->getMergeFieldCount());
        $this->assertThat($mailing_list_stats->getAvgSubRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($mailing_list_stats->getTargetSubRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($mailing_list_stats->getOpenRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($mailing_list_stats->getClickRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertInstanceOf(\DateTime::class, $mailing_list_stats->getLastSubDate());
        $this->assertInstanceOf(\DateTime::class, $mailing_list_stats->getLastUnsubDate());
    }

    function test_Bonobo_Report_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\Report::class, $report);
        $this->assertInternalType('string', $report->getId());
        $this->assertInternalType('string', $report->getCampaignTitle());
        $this->assertInternalType('string', $report->getType());
        $this->assertInternalType('string', $report->getListId());
        $this->assertInternalType('boolean', $report->getListIsActive());
        $this->assertInternalType('string', $report->getListName());
        $this->assertInternalType('string', $report->getSubjectLine());
        $this->assertInternalType('string', $report->getPreviewText());
        $this->assertInternalType('integer', $report->getEmailsSent());
        $this->assertInternalType('integer', $report->getAbuseReports());
        $this->assertInternalType('integer', $report->getUnsubscribed());
        $this->assertInstanceOf(\DateTime::class, $report->getSendTime());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\Bounces::class, $report->getBounces());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\Forwards::class, $report->getForwards());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\Opens::class, $report->getOpens());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\Clicks::class, $report->getClicks());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\FacebookLikes::class, $report->getFacebookLike());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\ListStats::class, $report->getListStats());
        $this->assertInternalType('array', $report->getTimeseries());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\Ecommerce::class, $report->getEcommerce());
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\DeliveryStatus::class, $report->getDeliveryStatus());
    }

    function test_Bonobo_Report_Bounces_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $bounce = $report->getBounces();
        $this->assertInternalType('integer', $bounce->getHardBounces());
        $this->assertInternalType('integer', $bounce->getSoftBounces());
        $this->assertInternalType('integer', $bounce->getSyntaxErrors());
    }

    function test_Bonobo_Report_Clicks_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $clicks = $report->getClicks();
        $this->assertInternalType('integer', $clicks->getClicksTotal());
        $this->assertInternalType('integer', $clicks->getUniqueClicks());
        $this->assertInternalType('integer', $clicks->getUniqueSubscriberClicks());
        $this->assertThat($clicks->getClickRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertInstanceOf(\DateTime::class, $clicks->getLastClick());
    }

    function test_Bonobo_Report_DeliveryStatus_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $this->assertInternalType('boolean', $report->getDeliveryStatus()->getEnabled());
    }

    function test_Bonobo_Report_Ecommerce_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $ecommerce = $report->getEcommerce();
        $this->assertInternalType('integer', $ecommerce->getTotalOrders());
        $this->assertThat($ecommerce->getTotalSpent(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($ecommerce->getTotalRevenue(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
    }

    function test_Bonobo_Report_FacebookLikes_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $facebook_likes = $report->getFacebookLike();
        $this->assertInternalType('integer', $facebook_likes->getRecipientLikes());
        $this->assertInternalType('integer', $facebook_likes->getUniqueLikes());
        $this->assertInternalType('integer', $facebook_likes->getFacebookLikes());
    }

    function test_Bonobo_Report_Forwards_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $forwards = $report->getForwards();
        $this->assertInternalType('integer', $forwards->getForwardsCount());
        $this->assertInternalType('integer', $forwards->getForwardsOpens());
    }

    function test_Bonobo_Report_ListStats_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $list_stats = $report->getListStats();
        $this->assertThat($list_stats->getSubRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($list_stats->getUnsubRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($list_stats->getOpenRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($list_stats->getClickRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
    }

    function test_Bonobo_Report_Opens_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $opens = $report->getOpens();
        $this->assertInternalType('integer', $opens->getOpensTotal());
        $this->assertInternalType('integer', $opens->getUniqueOpens());
        $this->assertThat($opens->getOpenRate(), $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertInstanceOf(\DateTime::class, $opens->getLastOpen());
    }

    function test_Bonobo_Report_TimeseriesElement_methods() {
        $bonobo = new Bonobo(getEnv("MAILCHIMP_VALID_KEY"));
        $reports = $bonobo->getReports();
        $this->assertInternalType('array', $reports);
        $this->assertNotEmpty($reports);
        $report = current($reports);
        $timeseries_elements = $report->getTimeseries();
        $this->assertInternalType('array', $timeseries_elements);
        /* @var $timeseries_element \Alberthorta\Bonobo\Report\TimeseriesElement */
        $timeseries_element = current($timeseries_elements);
        $this->assertInstanceOf(Alberthorta\Bonobo\Report\TimeseriesElement::class, $timeseries_element);
        $this->assertInstanceOf(\DateTime::class, $timeseries_element->getTimestamp());
        $this->assertInternalType('integer', $timeseries_element->getEmailsSent());
        $this->assertInternalType('integer', $timeseries_element->getUniqueOpens());
        $this->assertInternalType('integer', $timeseries_element->getRecipientsClicks());
    }
}
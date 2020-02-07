<?php

namespace Drupal\ch_split\EventSubscriber;

use Drupal\acquia_contenthub_publisher\ContentHubPublisherEvents;
use Drupal\acquia_contenthub_publisher\Event\ContentHubEntityEligibilityEvent;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribes to ACH entity eligibility to prevent config splits.
 */
class ContentHubEntityEligibilitySubscriber implements EventSubscriberInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * ContentHubEntityEligibilitySubscriber constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Prevent config split entities from enqueueing if configured.
   *
   * @param \Drupal\acquia_contenthub_publisher\Event\ContentHubEntityEligibilityEvent $event
   *   The event to determine entity eligibility.
   */
  public function onEnqueueCandidateEntity(ContentHubEntityEligibilityEvent $event) {
    $prevent_config_split_export = $this->configFactory->get('ch_split.settings')->get('prevent_config_split_export');
    if (!$prevent_config_split_export ||
        $event->getEntity()->getEntityTypeId() !== 'config_split') {
      return;
    }
    // If entity is a config split entity, and prevent_config_split_export has
    // been set to TRUE, do not export.
    $event->setEligibility(FALSE);
    $event->stopPropagation();
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Only handle event if the event class exists - when the
    // acquia_contenthub_publisher module is enabled.
    if (!class_exists('\Drupal\acquia_contenthub_publisher\ContentHubPublisherEvents')) {
      return [];
    }

    $events[ContentHubPublisherEvents::ENQUEUE_CANDIDATE_ENTITY] = ['onEnqueueCandidateEntity'];
    return $events;
  }

}

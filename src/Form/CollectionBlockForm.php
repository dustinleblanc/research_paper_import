<?php

namespace Drupal\zotero_import\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\zotero_import\Controller\ZoteroImportController;

/**
 * Class CollectionBlockForm.
 *
 * @package Drupal\zotero_import\Form
 */
class CollectionBlockForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'collection_block_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['fetch_all'] = [
      '#description' => $this->t('Fetch all items for User&#039;s Zotero library'),
      '#title' => $this->t('Fetch Zotero library'),
      '#type' => 'button',
      '#value' => t('Fetch Zotero library'),
      '#ajax' => [
        'callback' => [$this, 'fetchLibraryAjax'],
        'wrapper' => 'edit-zotero-items',
        'event' => 'mousedown',
        'prevent' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Fetching Zotero collections...'),
        ]
      ],
    ];

    $form['zotero-items'] = [
      '#description' => $this->t('Items returned by the Zotero API.'),
      '#title' => $this->t('Items'),
      '#type' => 'container',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }

  }

  public function fetchLibraryAjax(array &$form, FormStateInterface $form_state) {
    $controller = new ZoteroImportController();
    $items = $controller->fetchLibrary();
    $renderable_items = [
      '#theme' => 'zotero_collection',
      '#type' => 'element',
      'elements' => $items,
    ];
    $markup = \Drupal::service('renderer')->render($renderable_items);
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#edit-zotero-items', $markup));
    return $response;
  }

}

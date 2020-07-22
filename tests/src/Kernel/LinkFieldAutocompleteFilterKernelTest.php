<?php

namespace Drupal\Tests\link_field_autocomplete_filter\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;

/**
 * Link field autocomplete filter kernel tests.
 *
 * @group link_field_autocomplete_filter
 */
class LinkFieldAutocompleteFilterKernelTest extends KernelTestBase {

  use ContentTypeCreationTrait;

  /**
   * Entity storage interface.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $nodeTypeStorage;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'field',
    'text',
    'user',
    'node',
    'link_field_autocomplete_filter',
  ];

  /**
   * {@inheritDoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installSchema('system', 'sequences');
    $this->installSchema('node', 'node_access');
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installConfig('node');
    $this->installConfig('text');
    $this->createContentType([
      'type' => 'test_content',
      'display_submitted' => FALSE,
    ]);
    $this->nodeTypeStorage = $this->container->get('entity_type.manager')->getStorage('node_type');
  }

  /**
   * Test content type options.
   */
  public function testContentTypesOptions() {
    $content_types_entities = $this->nodeTypeStorage->loadMultiple();
    $content_types = array_map(function ($content_type) {
      return $content_type->id();
    }, $content_types_entities);
    $actual_types = _link_field_autocomplete_content_types_options();
    $this->assertEquals($content_types, $actual_types);
  }

}

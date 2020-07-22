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
    // Init default schemas and configurations.
    $this->installSchema('system', 'sequences');
    $this->installSchema('node', 'node_access');
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installConfig('node');
    $this->installConfig('text');
    // Create required content types.
    $this->createContentType([
      'type' => 'host_type',
      'name' => 'Host type',
      'display_submitted' => FALSE,
    ]);
    $this->createContentType([
      'type' => 'referencable_type',
      'name' => 'Referencable type',
      'display_submitted' => FALSE,
    ]);
  }

  /**
   * Test content type options.
   */
  public function testContentTypesOptions() {
    // Test allowed content types options.
    $actual_types = _link_field_autocomplete_content_types_options();
    $this->assertEquals(2, count($actual_types));
    $this->assertEquals([
      'host_type' => 'host_type',
      'referencable_type' => 'referencable_type',
    ], $actual_types);
  }

}

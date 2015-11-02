<?php
namespace Drupal\paypal\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'Hello' Block
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 * )
 */
class HelloBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
  	
	$a=$current_path = \Drupal::service('path.current')->getPath();
	$b=\Drupal::request()->getRequestUri();
	
	//SELECT * FROM `commerce_product_field_data` WHERE product_id='7'
	
	$uri = db_select('commerce_product_field_data', 'f')
		    ->condition('f.product_id', 7, '=')
		    ->fields('f', array('title'))
		    ->execute()->fetchField();
		  //echo $uri;
		
		  
    return array(
      '#markup' =>$uri,
    );
  }
}
?>
<?php
namespace Drupal\paypal\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'ProductInfo' Block
 *
 * @Block(
 *   id = "product_info",
 *   admin_label = @Translation("ProductInfo"),
 * )
 */
class ProductInfo extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

	$a=$current_path = \Drupal::service('path.current')->getPath();
	$b=\Drupal::request()->getRequestUri();
		
	$node_Id=explode("/",$b);
	
	$Id=$node_Id[3];
	$pro = array();	
	
  	$sel = db_query("SELECT * FROM {commerce_product_field_data} WHERE product_id=$Id");
    foreach ($sel as $value) {
		$pro['title'] =	$value->title;
		$pro['type'] =	$value->type;
	}

	$pro_body = array();	
	$sel = db_query("SELECT * FROM {commerce_product__body} WHERE entity_id=$Id");
    foreach ($sel as $value) {
		$pro_body['body_value'] =	$value->body_value;
	}	

	$var_id = array();	
	$sel = db_query("SELECT * FROM {commerce_product__variations} WHERE entity_id=$Id");
    foreach ($sel as $value) {
		$var_id['variations_target_id'] =	$value->variations_target_id; //variation_id
	}
	
	$var_target_id=$var_id['variations_target_id'];
	
	$img_id=array();
	
	$sel = db_query("SELECT * FROM {commerce_product_variation__field_wiring_diagram} WHERE entity_id=$var_target_id");
	
    foreach ($sel as $value) {
		$img_id['field_wiring_diagram_target_id'] =	$value->field_wiring_diagram_target_id; //field_id
	}

	$img_src_id=$img_id['field_wiring_diagram_target_id'];

	if($img_src_id!=''){
	$img_path=array();
	$sel = db_query("SELECT * FROM {file_managed} WHERE fid=$img_src_id");
	
	
    foreach ($sel as $value) {
		$img_path['filename'] =	$value->filename; //filename
	}

	$image_path=$img_path['filename'];
	}
	else{
		$image_path='';
	}
	
	$prc = db_query("SELECT * FROM {commerce_product_variation_field_data} WHERE variation_id=$var_target_id");
	
    foreach ($prc as $value) {
		$price['price__amount'] =	$value->price__amount; //field_id
	}

	$product_price=$price['price__amount'];
	
	$reslt['#attached']['library'][] = 'paypal/paypal_css'; 
		
	$product_info='<div class="div_right"><img src="../sites/default/files/'.$image_path.'"/></div><div class="div_left">';
	
	$product_info.='<b>'.$pro['title'].'</b>'.$pro_body['body_value'];
	
	$product_info.='</div><div class="">'.$product_price.'</div>';
		
	$reslt[]= array(
      '#markup' => '<div id="tabs">
  <ul>
  <li><a href="#tabs-1">Product Customize tab</a></li>
	<li><a href="#tabs-2">Questions tab</a></li>
	<li><a href="#tabs-3">Community tab</a></li>
  </ul>
  <div id="tabs-1">
	<p>'.$product_info.'</p>
  </div>
  <div id="tabs-2">
	<p>Tab one content.</p
  </div>
  <div id="tabs-3">
	<p>tab three content.</p>
  </div>
</div>',
    );
	
	


    
    return $reslt;
  }
}
?>
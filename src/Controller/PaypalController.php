<?php
/**
 * @file
 * @author Rakesh James
 * Contains \Drupal\example\Controller\ExampleController.
 * Please place this file under your example(module_root_folder)/src/Controller/
 */
namespace Drupal\paypal\Controller;


//use Drupal\Core\Form\FormInterface;

use Drupal\comment\CommentInterface;
use Drupal\comment\CommentStorageInterface;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides route responses for the Example module.
 */
class PaypalController {
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */

   public function myPage() {
	    $element = array(
	      '#markup' => 'Test PayPal',
	    );
	    return $element;
	}
  }

?>
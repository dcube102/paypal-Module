<?php
/**
 * @file
 * Contains \Drupal\paypal\Form\PaypalForm.
 */

namespace Drupal\paypal\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paypal\PAYPAL_PRO;
/**
 * Implements an paypal form.
 */
class PaypalForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'paypal_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	
	$form[]= array(
      '#markup' => '<div class="div_left">',
    );
	
	$form[]= array(
      '#markup' => 'Personal Information',
    );
	
    $form['fname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('First Name')
    );
	$form['lname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Name')
    );
	$form['amount'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Amount')
    );
	$form['zip'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Zip')
    );
	$form[]= array(
      '#markup' => '</div><div class="div_right">',
    );
	
	
	$form[]= array(
      '#markup' => 'Credit Card Information',
    );
	
	$form['creditCardType'] = array(
      '#type' => 'select',
      '#options' => array('Visa'=>'Visa','MasterCard'=>'MasterCard','Discover'=>'Discover','Amex'=>'American Express'),
      '#title' => $this->t('Card Type'),
      '#value'=>'Visa'
    );
	$form['creditCardNumber'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Card Number')
    );
	$form['expDateMonth'] = array(
      '#type' => 'select',
      '#options' => array('1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10','11'=>'11','12'=>'12'),
      '#title' => $this->t('Expiration Date'),
      '#value'=>'12'
    );
	
	$form['expDateYear'] = array(
      '#type' => 'select',
      '#options' => array(
      '2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017',
      '2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022',
      '2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027',
      '2028'=>'2028','2029'=>'2029','2030'=>'2030'),
      '#value'=>'2015'
    );
	
									
										
	$form['cvv2Number'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('CVV Number')
    );
	
	$form[]= array(
      '#markup' => '</div>',
    );
	
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Pay'),
      '#button_type' => 'primary',
    );
	
	
	$form['#attached']['library'][] = 'paypal/paypal_css'; 
	// Name of the key would be the key that you have defined in module_name.libraries.yml file.
 	
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('fname')) !='') {
      //$form_state->setErrorByName('fname', $this->t('The phone number is too short. Please enter a full phone number.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  	
	//debug($form_state);

	$zip = $form_state->getValue('zip');
	$creditCardNumber = $form_state->getValue('creditCardNumber');
	$expDateMonth =$form_state->getValue('expDateMonth');
	$expDateYear =$form_state->getValue('expDateYear');
	$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
	$cvv2Number = $form_state->getValue('cvv2Number');
	$creditCardType =$form_state->getValue('creditCardType');
	$amount = $form_state->getValue('amount');
	
	$currencyCode="USD";
	$paymentAction = "Sale";
	
	$nvpRecurring = '';
	$methodToCall = 'doDirectPayment';
	
	$address1='Test';
	$firstName=$form_state->getValue('fname');
	$lastName=$form_state->getValue('lname');
	$city='';
	$state='';
	$nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.         $padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;
	
	
	$paypalPro = new PAYPAL_PRO('dcube102_api1.gmail.com', 'A2Z27W9TT38YF99A', 'AhASSJKy6.CmpxA-YrdIVjL0aAmMAsDBSX7w3genQDH3xdQ-ubK-9T5k', '', '', FALSE, FALSE );
	$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
	$ack = strtoupper($resArray["ACK"]);
	print_r($resArray);
	

	if($resArray["ACK"]=='Success'){
	drupal_set_message($this->t('Your Payment is @ack and your Transaction ID is @trans', array('@ack' =>$resArray["ACK"],'@trans'=>$resArray["TRANSACTIONID"])));
	}
	else{
      drupal_set_message('Payment Failure:'.$resArray["L_LONGMESSAGE0"], 'error');
	}

  }

}

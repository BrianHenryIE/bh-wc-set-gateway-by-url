<?php

class VerifyGatewayCest {

	public function _before( AcceptanceTester $I ) {

	}


	/**
	 *
	 * @param AcceptanceTester $I
	 */
	public function testSetGatewayOnCheckout( AcceptanceTester $I ) {

		$I->wantTo( 'Add a product to cart, visit checkout, setting the payment gateway there, then see the payment gateway is cod.' );

		$I->amOnPage( '/index.php/product/prod-003/' );

		$I->see( 'Add to cart', 'button' );

		$I->click( '.single_add_to_cart_button' );

		$I->canSee( '“Prod 003” has been added to your cart.' );

		$I->amOnPage( '/index.php/checkout/?payment_gateway=cod' );

		$I->canSee( 'Your order' );

		$I->seeOptionIsSelected( '#payment_method_cod', 'cod' );
	}

	/**
	 *
	 * @param AcceptanceTester $I
	 */
	public function testSetGatewayOnHome( AcceptanceTester $I ) {

		$I->wantTo( 'Set the payment gateway on the homepage, add a product to cart, visit checkout and see the payment gateway is cheque.' );

		$I->amOnPage( '/?payment_gateway=cheque' );

		$I->amOnPage( '/index.php/product/prod-003/' );

		$I->see( 'Add to cart', 'button' );

		$I->click( '.single_add_to_cart_button' );

		$I->canSee( '“Prod 003” has been added to your cart.' );

		$I->amOnPage( '/index.php/checkout/' );

		$I->canSee( 'Your order' );

		$I->seeOptionIsSelected( '#payment_method_cheque', 'cheque' );
	}

}

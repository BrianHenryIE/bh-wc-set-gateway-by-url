<?php

class PluginsPageCest {

	/**
	 * Check the plugin is in the plugins.php list.
	 * For local dev environment, verifies the symlink is correct.
	 * Verifies the name is unchanged.
	 *
	 * @param AcceptanceTester $I The CodeCeption actor.
	 */
	public function testPluginsPageForPluginName( AcceptanceTester $I ) {

		$I->loginAsAdmin();

		$I->amOnPluginsPage();

		$I->canSee( 'Set Gateway By URL' );
	}

}
